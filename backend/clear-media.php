<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$count = DB::table('media')->count();
echo "Found {$count} media records\n";

DB::table('media')->delete();

echo "Deleted all media records successfully!\n";
