<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): mixed
{
    // Cek apakah user sudah login DAN apakah role-nya sesuai
    // Gunakan \Illuminate\Support\Facades\Auth agar lebih aman
    if (!\Illuminate\Support\Facades\Auth::check() || \Illuminate\Support\Facades\Auth::user()->role !== $role) {
        abort(403, 'Akses ditolak.');
    }

    return $next($request);
}
}
