<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403, 'No tienes permisos para acceder');
        }

        return $next($request);
    }

}
