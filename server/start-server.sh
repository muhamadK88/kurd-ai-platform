#!/usr/bin/env bash
set -e

DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PORT=${1:-8000}
WORKERS=${2:-4}
LOG=/tmp/opencode/kurdai
mkdir -p "$LOG"

pkill -f 'artisan serve' 2>/dev/null || true
pkill -f 'server/prox[y].py' 2>/dev/null || true
sleep 1

for i in $(seq 1 "$WORKERS"); do
  P=$((PORT + i))
  setsid nohup php "$DIR/../artisan" serve --host=0.0.0.0 --port=$P > "$LOG/worker-$P.log" 2>&1 < /dev/null &
  echo "worker $i -> 0.0.0.0:$P (pid $!)"
done

sleep 2
setsid nohup python3 "$DIR/proxy.py" "$PORT" > "$LOG/proxy.log" 2>&1 < /dev/null &
echo "proxy -> 0.0.0.0:$PORT (pid $!)"
sleep 1

curl -s -o /dev/null -w "check: http://127.0.0.1:$PORT -> %{http_code}\n" "http://127.0.0.1:$PORT/" || true
