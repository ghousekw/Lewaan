# Script to seed Railway production database
# Run this from the backend directory

Write-Host "🚀 Seeding Railway Production Database" -ForegroundColor Cyan
Write-Host ""

# Get Railway database credentials
Write-Host "Please provide your Railway PostgreSQL credentials:" -ForegroundColor Yellow
Write-Host "(You can find these in Railway Dashboard > PostgreSQL > Variables)" -ForegroundColor Gray
Write-Host ""

$PGHOST = Read-Host "PGHOST (e.g., postgres.railway.internal)"
$PGPORT = Read-Host "PGPORT (default: 5432)"
$PGDATABASE = Read-Host "PGDATABASE"
$PGUSER = Read-Host "PGUSER"
$PGPASSWORD = Read-Host "PGPASSWORD" -AsSecureString
$PGPASSWORD_Plain = [Runtime.InteropServices.Marshal]::PtrToStringAuto([Runtime.InteropServices.Marshal]::SecureStringToBSTR($PGPASSWORD))

Write-Host ""
Write-Host "⚠️  WARNING: This will seed the PRODUCTION database!" -ForegroundColor Red
Write-Host "Press Ctrl+C to cancel, or any key to continue..." -ForegroundColor Yellow
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")

Write-Host ""
Write-Host "🔄 Running seeder..." -ForegroundColor Cyan

# Set environment variables temporarily for this session
$env:DB_CONNECTION = "pgsql"
$env:DB_HOST = $PGHOST
$env:DB_PORT = $PGPORT
$env:DB_DATABASE = $PGDATABASE
$env:DB_USERNAME = $PGUSER
$env:DB_PASSWORD = $PGPASSWORD_Plain
$env:PGSQL_SSL_MODE = "require"

# Run the seeder
php artisan db:seed --class=PortfolioSeederWithoutImages

Write-Host ""
Write-Host "✅ Done! Check your Railway database." -ForegroundColor Green
