<?php

namespace App\Http\Middleware;

use Closure;

class BlockAdminEmployeeOnClient
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->is_admin || ($user->is_employee ?? false)) {
                abort(403, 'Esta sección es solo para clientes.');
            }
        }

        return $next($request);
    }
}


