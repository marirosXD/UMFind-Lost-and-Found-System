<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in and has admin role
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access. Admin only area.');
        }
        
        return $next($request);
    }
}