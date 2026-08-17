#!/usr/bin/env bash
set -euo pipefail

APP_DIR="/home/u739214395/domains/kurd-ai.com/public_html"
ENV_DECRYPT_KEY="${1:-}"

cd "$APP_DIR"

chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

if [[ -f .env.encrypted && ! -f .env && -n "$ENV_DECRYPT_KEY" ]]; then
  php artisan env:decrypt --force --key="$ENV_DECRYPT_KEY"
fi

php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deploy finished successfully."
