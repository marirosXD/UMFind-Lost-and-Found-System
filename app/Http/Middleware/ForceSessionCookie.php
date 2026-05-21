<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceSessionCookie
{
    public function handle(Request $request, Closure $next)
    {
        // Force session to start
        if (!session()->isStarted()) {
            session()->start();
        }
        
        // Ensure cookie has correct parameters
        $cookie = session()->getName();
        $value = session()->getId();
        
        // Set cookie manually if needed
        if (!isset($_COOKIE[$cookie])) {
            setcookie(
                $cookie,
                $value,
                [
                    'expires' => time() + (config('session.lifetime') * 60),
                    'path' => config('session.path', '/'),
                    'domain' => '.onrender.com',
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]
            );
        }
        
        return $next($request);
    }
}