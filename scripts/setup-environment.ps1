# Setup PHP and Composer Environment
# Run this script as Administrator

Write-Host "==================================" -ForegroundColor Cyan
Write-Host "PHP & Composer Environment Setup" -ForegroundColor Cyan
Write-Host "==================================" -ForegroundColor Cyan
Write-Host ""

# Check if running as Administrator
$isAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)

if (-not $isAdmin) {
    Write-Host "⚠️  Please run this script as Administrator!" -ForegroundColor Red
    Write-Host "Right-click PowerShell and select 'Run as Administrator'" -ForegroundColor Yellow
    pause
    exit
}

# Step 1: Add PHP to PATH
Write-Host "Step 1: Adding PHP to PATH..." -ForegroundColor Yellow

$phpPath = "C:\php"
$currentPath = [Environment]::GetEnvironmentVariable("Path", "Machine")

if ($currentPath -notlike "*$phpPath*") {
    [Environment]::SetEnvironmentVariable("Path", "$currentPath;$phpPath", "Machine")
    Write-Host "✅ PHP added to PATH" -ForegroundColor Green
} else {
    Write-Host "✅ PHP already in PATH" -ForegroundColor Green
}

# Step 2: Check if Composer is installed
Write-Host "`nStep 2: Checking Composer..." -ForegroundColor Yellow

$composerPath = "C:\ProgramData\ComposerSetup\bin"
if (Test-Path "$composerPath\composer.bat") {
    Write-Host "✅ Composer is installed" -ForegroundColor Green
    
    # Add Composer to PATH if not already
    if ($currentPath -notlike "*$composerPath*") {
        [Environment]::SetEnvironmentVariable("Path", "$currentPath;$composerPath", "Machine")
        Write-Host "✅ Composer added to PATH" -ForegroundColor Green
    }
} else {
    Write-Host "❌ Composer not found" -ForegroundColor Red
    Write-Host "   Download from: https://getcomposer.org/Composer-Setup.exe" -ForegroundColor Yellow
    Write-Host "   Run the installer and it will auto-detect PHP" -ForegroundColor Yellow
}

# Step 3: Verify installations
Write-Host "`nStep 3: Verification..." -ForegroundColor Yellow
Write-Host "Close and reopen your terminal, then run:" -ForegroundColor Cyan
Write-Host "  php -v" -ForegroundColor White
Write-Host "  composer -V" -ForegroundColor White
Write-Host "  psql --version" -ForegroundColor White

Write-Host "`n✅ Setup complete!" -ForegroundColor Green
Write-Host "⚠️  IMPORTANT: Close and reopen your terminal for changes to take effect!" -ForegroundColor Yellow

pause
