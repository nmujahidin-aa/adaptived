<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticated as Middleware;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Logika autentikasi Anda di sini
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('auth.login.index'); // Atau tangani sesuai kebutuhan
        }

        return $next($request);
    }
}
