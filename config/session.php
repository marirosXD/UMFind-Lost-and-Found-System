<?php

use Illuminate\Support\Str;

return [

    'driver' => env('SESSION_DRIVER', 'file'),

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    'encrypt' => env('SESSION_ENCRYPT', false),

    'files' => storage_path('framework/sessions'),

    'connection' => env('SESSION_CONNECTION'),

    'table' => env('SESSION_TABLE', 'sessions'),

    'store' => env('SESSION_STORE'),

    'lottery' => [2, 100],

    'cookie' => env('SESSION_COOKIE', 'laravel_session'),

    'path' => '/',

    // FORCE Render settings - check if on Render
    'domain' => (isset($_SERVER['RENDER']) || env('APP_ENV') === 'production') 
        ? '.onrender.com' 
        : env('SESSION_DOMAIN', null),

    'secure' => (isset($_SERVER['RENDER']) || env('APP_ENV') === 'production') 
        ? true 
        : env('SESSION_SECURE_COOKIE', false),

    'http_only' => true,

    'same_site' => 'lax',

    'partitioned' => false,

];