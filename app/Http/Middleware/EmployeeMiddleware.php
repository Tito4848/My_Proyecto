<?php

namespace App\Http\Middleware;

use Closure;

class EmployeeMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->is_employee) {
            abort(403, 'No tienes permisos para acceder (solo empleados).');
        }

        return $next($request);
    }
}


