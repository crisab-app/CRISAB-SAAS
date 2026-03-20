<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Validamos de forma flexible (acepta 1 o true)
        if ($user && $user->is_super_admin == true) {
            return $next($request);
        }

        abort(403, 'Acceso Denegado. Solo personal autorizado.');
    }
}