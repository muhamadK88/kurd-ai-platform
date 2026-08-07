#!/usr/bin/env bash
#
# fix_badini_ferga.sh
# -------------------
# Completes the 2026-08-07 Badini repair on the live Firebase `ferga_lessons` node.
# The earlier full-site repair missed 34 corruptions in `_ba` fields:
#   دهێتە      → دێتە        (30×) — Sorani passive-voice form
#   پروگرام    → پرۆگرام     ( 3×) — Sorani-less spelling
#   هەردووکیان → هەردووکان   ( 1×) — Sorani oblique suffix (Badini: herdukan)
# ONLY `_ba` fields are edited. Every `_so` field and every non-bilingual field
# (code, numbers, order, URLs, created_at, langId, quiz options, …) is verified
# byte-identical to the live state before the atomic PUT.
#
# Auth: service-account JWT from firebase_credentials.json (gitignored, repo root).
#   DRY_RUN=1 rebuild + verify + backup but do NOT write.
set -euo pipefail
cd "$(dirname "$0")/.."

FIREBASE_URL="${FIREBASE_URL:-https://ai-platform-adb1b-default-rtdb.firebaseio.com}"
CREDS="${CREDS:-firebase_credentials.json}"
DRY_RUN="${DRY_RUN:-0}"

b64url() { openssl base64 -A | tr '+/' '-_' | tr -d '='; }

WORK="$(mktemp -d)"
trap 'rm -rf "$WORK"' EXIT

if [[ ! -f "$CREDS" ]]; then echo "❌ $CREDS missing (gitignored service account)."; exit 1; fi

# --------------------------------------------------------------------------
echo "==> Fetching live ferga_lessons"
curl -sf "$FIREBASE_URL/ferga_lessons.json" -o "$WORK/live.json" \
    || { echo "❌ read failed"; exit 1; }
python3 -c 'import json;d=json.load(open("'$WORK/live.json'"));print(f"    live lessons: {len(d)}")'

# --------------------------------------------------------------------------
echo "==> Applying _ba-only Badini fixes with byte-identical verification"
python3 - "$WORK/live.json" "$WORK/fixed.json" <<'EOF'
import json, sys

live = json.load(open(sys.argv[1]))

REPL = [
    ('دهێتە',  'دێتە'),      # passive "is + participle"
    ('پروگرام','پرۆگرام'),   # spelling
    ('هەردووکیان','هەردووکان'),  # Sorani oblique suffix -> Badini herdukan
]

changed = 0
fixed_fields = {}   # lesson -> {field -> count}
for key, lesson in live.items():
    for field, val in lesson.items():
        if not field.endswith('_ba') or not isinstance(val, str):
            continue
        n = sum(val.count(old) for old, _ in REPL)
        if n:
            for old, new in REPL:
                val = val.replace(old, new)
            lesson[field] = val
            fixed_fields[key] = fixed_fields.get(key, {})
            fixed_fields[key][field] = n
            changed += n

# --- verification 1: total replacements exactly as expected ---
total = sum(c for m in fixed_fields.values() for c in m.values())
expected = 34
print(f"    replacements: {total} (expected {expected})")
if total != expected:
    print("❌ replacement count mismatch — aborting"); sys.exit(1)

# --- verification 2: every non-_ba field byte-identical ---
bad = []
for key, lesson in live.items():
    for field, val in lesson.items():
        if field.endswith('_ba'):
            continue
        if val != json.load(open(sys.argv[1]))[key][field]:
            bad.append(f"{key}.{field}")
if bad:
    print("❌ non-_ba fields changed! " + ", ".join(bad[:10])); sys.exit(1)
print("    ✓ all non-_ba fields byte-identical (incl. every _so)")

# --- verification 3: no corruption token left in any _ba field ---
leftover = {old: 0 for old, _ in REPL}
for key, lesson in live.items():
    for field, val in lesson.items():
        if field.endswith('_ba') and isinstance(val, str):
            for old in leftover:
                leftover[old] += val.count(old)
if any(leftover.values()):
    print("❌ leftovers: " + str(leftover)); sys.exit(1)
print("    ✓ zero corruptions left in _ba")

json.dump(live, open(sys.argv[2], 'w'), ensure_ascii=False, indent=2)
print(f"    fixed lessons: {len(fixed_fields)}")
for k in sorted(fixed_fields):
    print(f"      {k}: {fixed_fields[k]}")
EOF

# --------------------------------------------------------------------------
echo "==> Backing up current live state"
BK="storage/backups/firebase-badini-fix2-$(date +%Y%m%d-%H%M%S)"
mkdir -p "$BK"
cp "$WORK/live.json" "$BK/ferga_lessons.json"
cp "$WORK/fixed.json" "$BK/ferga_lessons.fixed.json"
echo "    backup dir: $BK"

if [[ "$DRY_RUN" == "1" ]]; then
    echo "✅ DRY RUN — verified + backed up, nothing written."
    exit 0
fi

# --------------------------------------------------------------------------
echo "==> Minting service-account access token"
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
if [[ -z "$ACCESS_TOKEN" ]]; then echo "❌ token mint failed"; exit 1; fi
echo "    token OK"

# --------------------------------------------------------------------------
echo "==> Atomic PUT to /ferga_lessons.json"
CODE="$(curl -s -o "$WORK/put.json" -w '%{http_code}' \
    -X PUT "$FIREBASE_URL/ferga_lessons.json?access_token=$ACCESS_TOKEN" \
    -H 'Content-Type: application/json' \
    --data-binary @"$WORK/fixed.json")"
if [[ "$CODE" != "200" ]]; then
    echo "❌ PUT returned HTTP $CODE"; head -c 400 "$WORK/put.json"; echo; exit 1
fi

# --------------------------------------------------------------------------
echo "==> Read-back verification"
curl -sf "$FIREBASE_URL/ferga_lessons.json" -o "$WORK/readback.json"
python3 - "$WORK/fixed.json" "$WORK/readback.json" <<'EOF'
import json, sys
a = json.load(open(sys.argv[1])); b = json.load(open(sys.argv[2]))
if a == b:
    print(f"    ✓ read-back identical to pushed payload ({len(a)} lessons)")
else:
    diff = [k for k in a if a[k] != b.get(k)]
    print(f"    ❌ MISMATCH on {len(diff)} lessons: {diff[:10]}")
    sys.exit(1)
EOF
echo "✅ SUCCESS — ferga_lessons Badini repair completed. Backup: $BK"
