<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request)
            ->header('Access-Control-Allow-Origin', [
                'http:localhost:5173',
                'http://127.0.0.1:5173',
                'http://192.168.56.1:5173',
                'http://192.168.137.1:5173',
                'http://192.168.18.10:5173',
                'https://our-kpi-production.vercel.app'
            ])
            ->header('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT, PATCH, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->header('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
