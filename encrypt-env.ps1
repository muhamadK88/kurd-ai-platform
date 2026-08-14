$ErrorActionPreference = 'Stop'

if (-not (Test-Path -LiteralPath '.env')) {
    throw '.env was not found.'
}

Write-Host 'Encrypting .env for deployment...' -ForegroundColor Cyan
php artisan env:encrypt --env=production --force
Write-Host ''
Write-Host 'IMPORTANT: store the printed decryption key outside the project and outside the ZIP.' -ForegroundColor Yellow
Write-Host 'On the server run: powershell -ExecutionPolicy Bypass -File .\deploy-env.ps1 -Key YOUR_KEY'
