<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized action.'], 403);
            }
            return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
        }

        return $next($request);
    }
} 