# Portfolio Import Verification Script
# Checks if all portfolio projects were imported successfully

Write-Host "🔍 Verifying Portfolio Import..." -ForegroundColor Cyan
Write-Host ""

# Change to Laravel directory
Set-Location lewan-cms

Write-Host "📊 Checking database..." -ForegroundColor Yellow

# Create a temporary PHP script to check the database
$checkScript = @'
<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Portfolio;

echo "\n";
echo "Portfolio Projects in Database:\n";
echo "================================\n\n";

$portfolios = Portfolio::orderBy('order')->get();

if ($portfolios->count() === 0) {
    echo "❌ No portfolio projects found!\n";
    echo "   Run the import script first: .\\import-portfolio.bat\n\n";
    exit(1);
}

echo "Total Projects: " . $portfolios->count() . "\n\n";

foreach ($portfolios as $portfolio) {
    $imageCount = $portfolio->getMedia('gallery')->count();
    $status = $imageCount > 0 ? "✅" : "⚠️";
    
    printf("%s %2d. %-30s | %2d images | %s\n", 
        $status,
        $portfolio->order,
        $portfolio->title_en,
        $imageCount,
        $portfolio->status
    );
}

echo "\n";
echo "Summary:\n";
echo "--------\n";
$totalImages = Portfolio::all()->sum(function($p) { return $p->getMedia('gallery')->count(); });
$published = Portfolio::where('status', 'published')->count();
$featured = Portfolio::where('featured', true)->count();

echo "Total Images: $totalImages\n";
echo "Published: $published\n";
echo "Featured: $featured\n";
echo "\n";

if ($portfolios->count() === 14 && $totalImages > 0) {
    echo "✅ Import verification successful!\n";
    echo "\n";
    echo "Next steps:\n";
    echo "  1. Start server: php artisan serve\n";
    echo "  2. Visit admin: http://localhost:8000/admin\n";
    echo "  3. View portfolios: http://localhost:8000/admin/portfolios\n";
    echo "\n";
} else {
    echo "⚠️ Import may be incomplete.\n";
    echo "   Expected: 14 projects with images\n";
    echo "   Found: " . $portfolios->count() . " projects with $totalImages images\n";
    echo "\n";
}
'@

# Save and run the check script
$checkScript | Out-File -FilePath "check-import.php" -Encoding UTF8

php check-import.php

# Clean up
Remove-Item "check-import.php" -ErrorAction SilentlyContinue

# Return to root directory
Set-Location ..

Write-Host ""
Write-Host "Press any key to exit..." -ForegroundColor Gray
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
