<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        
        // Add ForceSessionCookie middleware to global stack
        $middleware->append(\App\Http\Middleware\ForceSessionCookie::class);
        
        // Add trust proxies for Render
        $middleware->trustProxies(at: '*');
        $middleware->trustProxies(headers: \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR |
                                         \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST |
                                         \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT |
                                         \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO);
        
        // DO NOT use config() here - it causes fatal error!
        // The session configuration is already handled in config/session.php
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();