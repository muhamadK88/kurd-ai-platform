param(
    [Parameter(Mandatory = $true)]
    [string]$Key
)

$ErrorActionPreference = 'Stop'

if (-not (Test-Path -LiteralPath '.env.encrypted')) {
    throw '.env.encrypted was not found in this deployment package.'
}

php artisan env:decrypt --force --key=$Key
php artisan migrate --force
php artisan optimize:clear
Write-Host 'Environment decrypted and Laravel prepared.' -ForegroundColor Green
