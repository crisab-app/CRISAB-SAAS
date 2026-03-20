<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckChurchStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // 1. Si es el SuperAdmin "Fantasma" (sin iglesia), no lo dejamos entrar a módulos locales
        // y lo redirigimos automáticamente a su Centro de Mando Global.
        if ($user && $user->is_super_admin && is_null($user->contract_id)) {
            return redirect()->route('superadmin.index')->with('error', 'Estás en modo SuperAdmin global. No tienes una iglesia local asignada para ver este módulo.');
        }

        // 2. Seguridad: Si es un usuario normal pero su cuenta perdió la relación con la iglesia
        if (!$user || !$user->contract) {
            abort(403, 'Error crítico: Tu usuario no tiene una iglesia asignada en el sistema.');
        }

        // 3. Cuarentena: Si la iglesia está suspendida por falta de pago o bloqueo
        if ($user->contract->status === 'suspended') {
            return redirect()->route('cuenta.suspendida');
        }

        // Si pasa todas las pruebas, lo dejamos entrar al módulo local
        return $next($request);
    }
}