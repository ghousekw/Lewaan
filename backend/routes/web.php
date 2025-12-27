<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Filament admin panel is now at the root path '/'
// No need for a welcome route

// Test route to verify authentication
Route::get('/test-auth', function (Request $request) {
    $email = 'gmshaik.kw@gmail.com';
    $password = 'Lewan2025!';
    
    $attempt = Auth::attempt(['email' => $email, 'password' => $password]);
    
    return response()->json([
        'auth_attempt' => $attempt ? 'SUCCESS' : 'FAILED',
        'authenticated' => Auth::check(),
        'user' => Auth::user(),
        'session_driver' => config('session.driver'),
        'session_secure' => config('session.secure'),
        'app_env' => config('app.env'),
        'app_url' => config('app.url'),
        'request_secure' => $request->secure(),
        'request_scheme' => $request->getScheme(),
    ]);
});
