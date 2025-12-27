<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Portfolio;

echo "\n";
echo "Portfolio Data Check\n";
echo "====================\n\n";

$portfolios = Portfolio::orderBy('order')->get();

echo "Total: " . $portfolios->count() . " portfolios\n\n";

foreach ($portfolios->take(3) as $portfolio) {
    echo "Order: {$portfolio->order}\n";
    echo "Slug: {$portfolio->slug}\n";
    echo "Title (EN): {$portfolio->title_en}\n";
    echo "Title (AR): {$portfolio->title_ar}\n";
    echo "Status: {$portfolio->status}\n";
    echo "Featured: " . ($portfolio->featured ? 'Yes' : 'No') . "\n";
    echo "Categories: " . implode(', ', $portfolio->categories ?? []) . "\n";
    echo "---\n\n";
}
