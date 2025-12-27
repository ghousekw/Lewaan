# Portfolio Import Script
# This script copies images and imports portfolio data into Laravel CMS

Write-Host "🚀 Starting Portfolio Import Process..." -ForegroundColor Cyan
Write-Host ""

# Define paths
$astroPublic = "public"
$laravelPublic = "lewan-cms\public"

# Portfolio folders to copy
$portfolioFolders = @(
    "Reception",
    "Deewaniya & Mughallath",
    "Living Hall",
    "Dining Hall",
    "Master Bedrooms",
    "Child Room",
    "Wash & Bathrooms",
    "Dressing Room",
    "Cinema Hall",
    "Corridors",
    "Kitchen,Pantry & Buffet",
    "Office",
    "Play Room",
    "Staircase"
)

# Step 1: Copy portfolio images
Write-Host "📁 Step 1: Copying portfolio images..." -ForegroundColor Yellow
Write-Host ""

$copiedCount = 0
$skippedCount = 0

foreach ($folder in $portfolioFolders) {
    $sourcePath = Join-Path $astroPublic $folder
    $destPath = Join-Path $laravelPublic $folder
    
    if (Test-Path $sourcePath) {
        Write-Host "  Copying: $folder" -ForegroundColor Gray
        
        # Create destination folder if it doesn't exist
        if (-not (Test-Path $destPath)) {
            New-Item -ItemType Directory -Path $destPath -Force | Out-Null
        }
        
        # Copy all files
        Copy-Item -Path "$sourcePath\*" -Destination $destPath -Recurse -Force
        
        $fileCount = (Get-ChildItem -Path $sourcePath -File).Count
        $copiedCount += $fileCount
        Write-Host "    ✓ Copied $fileCount images" -ForegroundColor Green
    } else {
        Write-Host "  ⚠ Folder not found: $folder" -ForegroundColor Red
        $skippedCount++
    }
}

Write-Host ""
Write-Host "✅ Image copy complete!" -ForegroundColor Green
Write-Host "   Total images copied: $copiedCount" -ForegroundColor Cyan
if ($skippedCount -gt 0) {
    Write-Host "   Folders skipped: $skippedCount" -ForegroundColor Yellow
}
Write-Host ""

# Step 2: Run Laravel seeder
Write-Host "📊 Step 2: Importing portfolio data into database..." -ForegroundColor Yellow
Write-Host ""

# Change to Laravel directory
Set-Location lewan-cms

# Run the seeder
Write-Host "  Running PortfolioSeeder..." -ForegroundColor Gray
php artisan db:seed --class=PortfolioSeeder

# Return to root directory
Set-Location ..

Write-Host ""
Write-Host "🎉 Portfolio import complete!" -ForegroundColor Green
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Cyan
Write-Host "  1. Start Laravel server: cd lewan-cms && php artisan serve" -ForegroundColor White
Write-Host "  2. Visit admin panel: http://localhost:8000/admin" -ForegroundColor White
Write-Host "  3. View portfolios: http://localhost:8000/admin/portfolios" -ForegroundColor White
Write-Host "  4. Test API: http://localhost:8000/api/v1/portfolio" -ForegroundColor White
Write-Host ""
