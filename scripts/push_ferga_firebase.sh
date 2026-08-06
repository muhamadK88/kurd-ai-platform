#!/usr/bin/env bash
#
# push_ferga_firebase.sh
# ----------------------
# Replaces the live Firebase `ferga_lessons` node with the generated curriculum
# using an ATOMIC PUT (no delete-then-post window, PY/JS keys preserved exactly).
#
#   • Preserves the existing Python + JavaScript lessons verbatim.
#   • Inserts the 6 generated curricula (C#, C++, Rust, HTML+CSS, PHP, Java)
#     from storage/curriculum/*.json.
#   • Backs up the current live state first.
#
# Auth: the RTDB requires a signed-in user token for writes. The importer signs
# in via Firebase Identity Toolkit with the same email/password used by the
# admin panel login. Provide them as environment variables (never hardcoded):
#
#   FIREBASE_ADMIN_EMAIL=you@example.com \
#   FIREBASE_ADMIN_PASSWORD='******' \
#   ./scripts/push_ferga_firebase.sh
#
# Or via a gitignored env file: .firebase-admin.env (EMAIL=... / PASSWORD=...)
#
# Safety switches:
#   DRY_RUN=1   rebuild + validate + backup, but do NOT write to Firebase
#   DATA_DIR=...  read curricula from another directory (default storage/curriculum)
#   FIREBASE_URL=...  override the RTDB base URL
set -euo pipefail

cd "$(dirname "$0")/.."

API_KEY="AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs"
FIREBASE_URL="${FIREBASE_URL:-https://ai-platform-adb1b-default-rtdb.firebaseio.com}"
DATA_DIR="${DATA_DIR:-storage/curriculum}"
DRY_RUN="${DRY_RUN:-0}"

CURRICULA=(csharp cpp rust htmlcss php java)

# --------------------------------------------------------------------------
echo "==> Reading credentials"
if [[ -z "${FIREBASE_ADMIN_EMAIL:-}" || -z "${FIREBASE_ADMIN_PASSWORD:-}" ]]; then
    if [[ -f .firebase-admin.env ]]; then
        # shellcheck disable=SC1091
        source .firebase-admin.env
    fi
fi
if [[ -z "${FIREBASE_ADMIN_EMAIL:-}" || -z "${FIREBASE_ADMIN_PASSWORD:-}" ]]; then
    echo "❌ Need FIREBASE_ADMIN_EMAIL and FIREBASE_ADMIN_PASSWORD (or .firebase-admin.env)."
    echo "   These are the credentials used by the platform admin login."
    exit 1
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
KEEP_IDS="|-OypFoFNvHfBuaA2Uh7O|-Oysj4NVk0PGRLQx2Z8o"  # Python, JavaScript
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
cp "$WORK/merged.json" "$WORK/ferga_lessons_new.json"

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
echo "==> Signing in to Firebase (Identity Toolkit)"
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

# --------------------------------------------------------------------------
echo "==> Atomic PUT to /ferga_lessons.json"
CODE="$(curl -s -o "$WORK/put_response.json" -w '%{http_code}' \
    -X PUT "$FIREBASE_URL/ferga_lessons.json?auth=$ID_TOKEN" \
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
