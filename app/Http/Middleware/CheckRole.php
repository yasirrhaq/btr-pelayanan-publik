<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            abort(403, 'Akses ditolak.');
        }

        // Admin master always has access
        if ($request->user()->hasRole('admin-master')) {
            return $next($request);
        }

        if (!$request->user()->hasAnyRole($roles)) {
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }

        return $next($request);
    }
}
