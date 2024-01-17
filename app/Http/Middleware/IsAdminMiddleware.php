<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()) {
            return response()->json([
                'error' => 'invalid_token'
            ], 403);
        }
        
        // return $next($request);
        if(Auth::user()->is_admin) {
            return $next($request);
        }

        return response()->json([
            'error' => "you can't access this route"
        ], 400);
    }
}
