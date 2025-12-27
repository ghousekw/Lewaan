# Fix Admin Panel Display
Write-Host "🔧 Fixing Admin Panel..." -ForegroundColor Cyan
Write-Host ""

Set-Location lewan-cms

Write-Host "1. Clearing all caches..." -ForegroundColor Yellow
php artisan optimize:clear

Write-Host ""
Write-Host "2. Clearing Filament cache..." -ForegroundColor Yellow
php artisan filament:clear-cached-components

Write-Host ""
Write-Host "3. Rebuilding assets..." -ForegroundColor Yellow
php artisan filament:assets

Write-Host ""
Write-Host "✅ Done!" -ForegroundColor Green
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Cyan
Write-Host "  1. Close your browser completely" -ForegroundColor White
Write-Host "  2. Start server: php artisan serve" -ForegroundColor White
Write-Host "  3. Open browser and visit: http://localhost:8000/admin" -ForegroundColor White
Write-Host "  4. Hard refresh: Ctrl+Shift+R or Ctrl+F5" -ForegroundColor White
Write-Host ""

Set-Location ..
