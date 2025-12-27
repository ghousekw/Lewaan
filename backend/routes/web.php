<?php

use Illuminate\Support\Facades\Route;

// Filament handles all routes at / (login, admin, dashboard)
// No need to define root route as Filament panel path is '/'

// Debug route to check configuration (remove after setup)
Route::get('/debug-config', function () {
    if (app()->environment('production')) {
        abort(404);
    }
    
    return response()->json([
        'filesystem_disk' => config('filesystems.default'),
        'media_disk' => config('media-library.disk_name'),
        'cloudinary_configured' => !empty(config('cloudinary.cloud_name')),
        'cloudinary_cloud_name' => config('cloudinary.cloud_name') ? 'Set' : 'Not Set',
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'memory_limit' => ini_get('memory_limit'),
        'gd_installed' => extension_loaded('gd'),
        'imagick_installed' => extension_loaded('imagick'),
    ]);
});
