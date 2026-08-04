#!/usr/bin/env bash
LOG=/tmp/opencode/kurdai/cf.log
mkdir -p "$(dirname "$LOG")"
exec ~/.local/bin/cloudflared tunnel --url http://localhost:8000 --no-autoupdate >> "$LOG" 2>&1 < /dev/null
