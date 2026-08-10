#!/usr/bin/env bash
#
# push_ferga_firebase.sh
# ----------------------
# Replaces the live Firebase `ferga_lessons` node with the generated curriculum
# using an ATOMIC PUT (no delete-then-post window, Python/JS keys preserved).
#
#   • Preserves the existing Python + JavaScript lessons verbatim.
#   • Inserts the 6 generated curricula (C#, C++, Rust, HTML+CSS, PHP, Java)
#     from storage/curriculum/*.json.
#   • Backs up the current live state first.
#
# Auth (in priority order):
#   1. Service account — if firebase_credentials.json exists in the repo root
#      (it is gitignored). Mints a Realtime Database access token from it.
#   2. Admin email/password — Firebase Identity Toolkit sign-in. Credentials
#      via env (FIREBASE_ADMIN_EMAIL/FIREBASE_ADMIN_PASSWORD) or a gitignored
#      .firebase-admin.env file.
#
# Safety switches:
#   DRY_RUN=1   rebuild + validate + backup, but do NOT write to Firebase
#   DATA_DIR=...  read curricula from another directory (default storage/curriculum)
#   FIREBASE_URL=...  override the RTDB base URL
set -euo pipefail

cd "$(dirname "$0")/.."

# The Firebase API key is NOT hardcoded here. Read it from the same external
# config the app uses (~/.config/kurd-ai/config.json) or FIREBASE_API_KEY env.
KAI_CFG="${HOME:-$HOME}/.config/kurd-ai/config.json"
API_KEY="${FIREBASE_API_KEY:-}"
if [[ -z "$API_KEY" && -f "$KAI_CFG" ]]; then
    API_KEY="$(python3 -c 'import json,sys;d=json.load(open(sys.argv[1]));print(d.get("firebase",{}).get("api_key",""))' "$KAI_CFG" 2>/dev/null || true)"
fi
if [[ -z "$API_KEY" ]]; then
    echo "❌ No Firebase API key. Set FIREBASE_API_KEY or add ~/.config/kurd-ai/config.json (see config/kurdai.php)."
    exit 1
fi
FIREBASE_URL="${FIREBASE_URL:-https://ai-platform-adb1b-default-rtdb.firebaseio.com}"
DATA_DIR="${DATA_DIR:-storage/curriculum}"
DRY_RUN="${DRY_RUN:-0}"
CREDS="${CREDS:-firebase_credentials.json}"

CURRICULA=(csharp cpp rust htmlcss php java)

b64url() { openssl base64 -A | tr '+/' '-_' | tr -d '='; }

# --------------------------------------------------------------------------
echo "==> Preparing credentials"
AUTH_MODE=""
if [[ -f "$CREDS" ]]; then
    AUTH_MODE="service_account"
    echo "    using service account: $(python3 -c 'import json;print(json.load(open("'$CREDS'"))["client_email"])' 2>/dev/null || echo "$CREDS")"
else
    if [[ -z "${FIREBASE_ADMIN_EMAIL:-}" || -z "${FIREBASE_ADMIN_PASSWORD:-}" ]]; then
        if [[ -f .firebase-admin.env ]]; then
            # shellcheck disable=SC1091
            source .firebase-admin.env
        fi
    fi
    if [[ -z "${FIREBASE_ADMIN_EMAIL:-}" || -z "${FIREBASE_ADMIN_PASSWORD:-}" ]]; then
        echo "❌ No service account ($CREDS) and no FIREBASE_ADMIN_EMAIL/PASSWORD."
        echo "   Either drop the project's service account at firebase_credentials.json"
        echo "   or set the admin email/password (the kurd-ai.com admin login)."
        exit 1
    fi
    AUTH_MODE="password"
    echo "    using admin email/password"
fi

# --------------------------------------------------------------------------
echo "==> Building merged payload (preserve Python + JS, add 6 curricula)"

WORK="$(mktemp -d)"
trap 'rm -rf "$WORK"' EXIT

# 1) Fetch live lessons (readable without auth)
LIVE="$WORK/ferga_lessons_live.json"
curl -sf "$FIREBASE_URL/ferga_lessons.json" -o "$LIVE" \
    || { echo "❌ Could not read live ferga_lessons (network/rules?)"; exit 1; }
echo "    live lessons read: $(python3 -c 'import json;print(len(json.load(open("'$LIVE'"))))' 2>/dev/null || echo '?')"

# 2) Filter live lessons down to the two languages we must NOT touch
python3 - "$LIVE" "$WORK/kept.json" <<'EOF'
import json, sys
live = json.load(open(sys.argv[1]))
keep = {'-OypFoFNvHfBuaA2Uh7O', '-Oysj4NVk0PGRLQx2Z8o'}
out = {k: v for k, v in live.items() if v.get('langId') in keep}
json.dump(out, open(sys.argv[2], 'w'), ensure_ascii=False, indent=2)
print(f"    preserving {len(out)} Python/JS lessons")
EOF

# 3) Append the 6 generated curricula under fresh keys
python3 - "$WORK/kept.json" "$WORK/merged.json" "$DATA_DIR" "${CURRICULA[@]}" <<'EOF'
import json, os, sys
out = json.load(open(sys.argv[1]))
data_dir, langs = sys.argv[3], sys.argv[4:]
for lang in langs:
    path = os.path.join(data_dir, f"{lang}.json")
    if not os.path.exists(path):
        print(f"    ⚠️  missing {path} — skipped")
        continue
    lessons = json.load(open(path))
    for n, lesson in enumerate(lessons, 1):
        key = f"L{lang}{n:02d}G"
        while key in out:
            key += "X"
        out[key] = lesson
    print(f"    + {len(lessons)} {lang} lessons")
json.dump(out, open(sys.argv[2], 'w'), ensure_ascii=False, indent=2)
EOF

TOTAL="$(python3 -c 'import json;print(len(json.load(open("'$WORK/merged.json'"))))')"
echo "    merged total: $TOTAL lessons"

# --------------------------------------------------------------------------
echo "==> Backing up current live state"
BK="storage/backups/firebase-replace-$(date +%Y%m%d-%H%M%S)"
mkdir -p "$BK"
cp "$LIVE" "$BK/ferga_lessons.json"
cp "$WORK/merged.json" "$BK/ferga_lessons.new.json"
echo "    backup dir: $BK"

if [[ "$DRY_RUN" == "1" ]]; then
    echo "✅ DRY RUN — payload rebuilt and backed up, nothing written."
    exit 0
fi

# --------------------------------------------------------------------------
echo "==> Authenticating"
if [[ "$AUTH_MODE" == "service_account" ]]; then
    # Mint a Realtime Database access token from the service account.
    CLIENT_EMAIL="$(python3 -c 'import json;print(json.load(open("'$CREDS'"))["client_email"])')"
    TOKEN_URI="$(python3 -c 'import json;print(json.load(open("'$CREDS'"))["token_uri"])')"
    NOW="$(date +%s)"; EXP="$((NOW + 3600))"
    HEADER="$(printf '%s' '{"alg":"RS256","typ":"JWT"}' | b64url)"
    CLAIMS="$(printf '{"iss":"%s","scope":"https://www.googleapis.com/auth/firebase.database https://www.googleapis.com/auth/userinfo.email","aud":"%s","iat":%s,"exp":%s}' "$CLIENT_EMAIL" "$TOKEN_URI" "$NOW" "$EXP" | b64url)"
    SIGNING_INPUT="${HEADER}.${CLAIMS}"
    printf '%s' "$SIGNING_INPUT" > "$WORK/signing_input"
    python3 -c 'import json;print(json.load(open("'$CREDS'"))["private_key"])' > "$WORK/svc.pem"
    openssl dgst -sha256 -sign "$WORK/svc.pem" -out "$WORK/sig" "$WORK/signing_input"
    JWT="${SIGNING_INPUT}.$(cat "$WORK/sig" | b64url)"
    ACCESS_TOKEN="$(curl -sf -X POST "$TOKEN_URI" \
        --data-urlencode "grant_type=urn:ietf:params:oauth:grant-type:jwt-bearer" \
        --data-urlencode "assertion=$JWT" | python3 -c 'import json,sys;print(json.load(sys.stdin).get("access_token",""))' || true)"
    if [[ -z "$ACCESS_TOKEN" ]]; then
        echo "❌ Could not mint a token from $CREDS — is it the right project's service account?"
        exit 1
    fi
    echo "    token minted from service account"
    AUTH_PARAM="access_token=$ACCESS_TOKEN"
else
    TOKEN_JSON="$(curl -sf -X POST \
        "https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key=$API_KEY" \
        -H 'Content-Type: application/json' \
        -d "{\"email\":\"$FIREBASE_ADMIN_EMAIL\",\"password\":\"$FIREBASE_ADMIN_PASSWORD\",\"returnSecureToken\":true}" \
        || true)"
    ID_TOKEN="$(python3 -c "import json,sys;print(json.loads(sys.argv[1]).get('idToken',''))" "$TOKEN_JSON" 2>/dev/null || true)"
    if [[ -z "$ID_TOKEN" ]]; then
        echo "❌ Sign-in failed — check the admin email/password."
        echo "   Server said: $(python3 -c "import json,sys;d=json.loads(sys.argv[1]);print(d.get('error',{}).get('message',''))" "$TOKEN_JSON" 2>/dev/null || echo "$TOKEN_JSON" | head -c 200)"
        exit 1
    fi
    echo "    signed in as $FIREBASE_ADMIN_EMAIL"
    AUTH_PARAM="auth=$ID_TOKEN"
fi

# --------------------------------------------------------------------------
echo "==> Atomic PUT to /ferga_lessons.json"
CODE="$(curl -s -o "$WORK/put_response.json" -w '%{http_code}' \
    -X PUT "$FIREBASE_URL/ferga_lessons.json?$AUTH_PARAM" \
    -H 'Content-Type: application/json' \
    --data-binary @"$WORK/merged.json")"

if [[ "$CODE" == "200" ]]; then
    echo "✅ SUCCESS — ferga_lessons replaced ($TOTAL lessons)."
    echo "   Backup: $BK"
    exit 0
else
    echo "❌ PUT returned HTTP $CODE"
    head -c 400 "$WORK/put_response.json"; echo
    exit 1
fi
