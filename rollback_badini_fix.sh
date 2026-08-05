#!/usr/bin/env bash
#
# Undoes apply_badini_fix.sh by restoring the pre-change Firebase backup.
#
# Restores all 8 nodes exactly as they were at 2026-08-05 16:36, before any
# Badini correction was applied. Both _ba and _so fields return to that state.
#
set -euo pipefail

DB="https://ai-platform-adb1b-default-rtdb.firebaseio.com"
SRC="$(cd "$(dirname "$0")" && pwd)/storage/backups/firebase-PRE-badini-fix-20260805-163653"

if [ ! -d "$SRC" ]; then
  echo "ERROR: backup not found at $SRC" >&2
  exit 1
fi

echo "This will OVERWRITE the live database with the backup from $SRC"
read -r -p "Type 'restore' to continue: " confirm
[ "$confirm" = "restore" ] || { echo "aborted."; exit 1; }

for n in ai_tools academic_guide ferga_lessons courses universities ferga_quizzes questions ferga_languages; do
  [ -f "$SRC/$n.json" ] || { echo "  $n : backup missing, skipped"; continue; }

  code=$(curl -s -X PUT -o /dev/null -w '%{http_code}' \
    -H 'Content-Type: application/json' \
    --data-binary @"$SRC/$n.json" \
    "$DB/$n.json")

  if [ "$code" = "200" ]; then
    echo "  $n : restored (HTTP 200)"
  else
    echo "  $n : FAILED (HTTP $code)" >&2
  fi
done

echo
echo "Rollback complete."
