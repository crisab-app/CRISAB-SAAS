<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckMembersPermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Si es el SuperAdmin global o tiene el check de miembros, lo dejamos pasar.
        if ($user && ($user->is_super_admin || $user->can_manage_members)) {
            return $next($request);
        }

        // Si no tiene permiso, lo bloqueamos.
        abort(403, '🔒 Acceso Denegado: No tienes privilegios para ver o modificar el Directorio de Miembros.');
    }
}