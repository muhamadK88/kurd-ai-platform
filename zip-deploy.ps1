# zip-deploy.ps1 - Creates a safe, shareable zip of the project that can be
# handed to a hoster WITHOUT leaking any secrets (.env, firebase admin
# credentials, AI API keys). API keys live in ~/.config/kurd-ai/, which is
# OUTSIDE the project folder and never included.
#
# Usage:   powershell -ExecutionPolicy Bypass -File zip-deploy.ps1
# Output:  kurd-ai-deploy.zip in the project root
#
# After running, READ the "OK / WARNING" line at the end.

$ErrorActionPreference = 'Stop'

$src   = $PSScriptRoot
$stage = Join-Path $env:TEMP ('kurd-ai-deploy-' + [guid]::NewGuid().ToString('N'))
$zip   = Join-Path $src 'kurd-ai-deploy.zip'

if (Test-Path -LiteralPath $zip) { Remove-Item -LiteralPath $zip -Force }

$xd = @(
    '.git', 'vendor', 'node_modules', '.idea', '.vscode', '.devcontainer',
    'storage\logs', 'storage\backups', 'storage\app\ai', '.config'
)
$xf = @(
    '.env', '.env.backup', '.env.production',
    'firebase_credentials.json',
    '*.zip', '*.log'
)

Write-Host "Staging copy (no secrets)..."
robocopy $src $stage /E /NFL /NDL /NJH /NJS /NP /XD $xd /XF $xf | Out-Null
if ($LASTEXITCODE -gt 7) { Write-Error "robocopy failed (code $LASTEXITCODE)"; exit 1 }

# Safety check: make sure nothing secret made it into the staged copy.
$rootEnv = Join-Path $stage '.env'
$rootFb  = Join-Path $stage 'firebase_credentials.json'
$leaks = @()
if (Test-Path -LiteralPath $rootEnv)  { $leaks += $rootEnv }
if (Test-Path -LiteralPath $rootFb)   { $leaks += $rootFb }
$leaks += Get-ChildItem -Path $stage -Recurse -Force -File -ErrorAction SilentlyContinue |
    Where-Object {
        $_.Name -like 'providers.json' -or
        $_.Name -like 'config.json' -or
        $_.Name -like 'deepseek_key*' -or
        $_.Name -like 'openrouter_key' -or
        $_.Name -like '*.key'
    } | ForEach-Object { $_.FullName }

if ($leaks.Count -gt 0) {
    Write-Host "WARNING: possible secrets found in the staged copy - zip was NOT created:" -ForegroundColor Red
    $leaks
    Remove-Item -LiteralPath $stage -Recurse -Force
    exit 1
}

Write-Host "Compressing..."
Compress-Archive -Path (Join-Path $stage '*') -DestinationPath $zip -CompressionLevel Optimal
Remove-Item -LiteralPath $stage -Recurse -Force

Write-Host ""
Write-Host "Created: $zip" -ForegroundColor Green
Write-Host "OK: no .env / firebase_credentials.json / API key files inside the zip."
