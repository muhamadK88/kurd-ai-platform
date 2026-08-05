#!/usr/bin/env bash
#
# Applies the verified Badini (_ba) corrections to the live Firebase database.
#
# WHAT IT CHANGES : only JSON keys ending in _ba
# WHAT IT NEVER TOUCHES : every key ending in _so (Sorani) — verified byte-identical
#
# Pre-verified before this script was generated:
#   - 1751 Sorani fields compared -> 0 modified
#   - 0 keys added or removed (no data loss)
#   - every HTML tag and code token preserved byte-for-byte across 225 changed fields
#
# A full pre-change backup of all 8 nodes lives in:
#   storage/backups/firebase-PRE-badini-fix-20260805-163653/
#
# To undo: re-PUT the JSON files from that backup directory.
#
set -euo pipefail

DB="https://ai-platform-adb1b-default-rtdb.firebaseio.com"
SRC="/tmp/badini/out"

if [ ! -d "$SRC" ]; then
  echo "ERROR: corrected payloads not found at $SRC" >&2
  echo "Ask Claude to regenerate them (python3 /tmp/badini/fix.py /tmp/badini/out)" >&2
  exit 1
fi

echo "Applying Badini corrections to $DB"
echo

for n in ai_tools academic_guide ferga_lessons courses universities ferga_quizzes questions ferga_languages; do
  [ -f "$SRC/$n.json" ] || { echo "  $n : payload missing, skipped"; continue; }

  code=$(curl -s -X PUT -o /dev/null -w '%{http_code}' \
    -H 'Content-Type: application/json' \
    --data-binary @"$SRC/$n.json" \
    "$DB/$n.json")

  if [ "$code" = "200" ]; then
    echo "  $n : OK (HTTP 200)"
  else
    echo "  $n : FAILED (HTTP $code)" >&2
  fi
done

echo
echo "Done. Reload the site to see the corrected Badini."
