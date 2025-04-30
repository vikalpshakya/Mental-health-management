<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExpertMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isExpert()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
} 