<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckFinancePermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Si es el SuperAdmin (Máster) o si tiene el check de finanzas, lo dejamos pasar.
        if ($user && ($user->is_super_admin || $user->can_manage_finances)) {
            return $next($request);
        }

        // Si no tiene permiso, lo pateamos con un error 403 (Prohibido)
        abort(403, '🔒 Acceso Denegado: No tienes privilegios para ver el módulo de Finanzas. Contacta al administrador de tu iglesia.');
    }
}