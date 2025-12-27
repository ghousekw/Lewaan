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
        'cloudinary_api_key' => config('cloudinary.api_key') ? 'Set' : 'Not Set',
        'cloudinary_api_secret' => config('cloudinary.api_secret') ? 'Set' : 'Not Set',
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'memory_limit' => ini_get('memory_limit'),
        'gd_installed' => extension_loaded('gd'),
        'imagick_installed' => extension_loaded('imagick'),
        'queue_driver' => config('queue.default'),
        'queue_conversions' => config('media-library.queue_conversions_by_default'),
    ]);
});

// Test Cloudinary connection
Route::get('/test-cloudinary', function () {
    try {
        $cloudinary = new \Cloudinary\Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key' => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
        ]);
        
        // Try to ping Cloudinary
        $result = $cloudinary->adminApi()->ping();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Cloudinary is configured correctly',
            'result' => $result,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'cloudinary_cloud_name' => config('cloudinary.cloud_name') ? 'Set' : 'Not Set',
            'cloudinary_api_key' => config('cloudinary.api_key') ? 'Set' : 'Not Set',
            'cloudinary_api_secret' => config('cloudinary.api_secret') ? 'Set' : 'Not Set',
        ], 500);
    }
});
