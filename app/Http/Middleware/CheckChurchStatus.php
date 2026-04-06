<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckChurchStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // 1. Si es el SuperAdmin, pasa directo sin restricciones
        if ($user && $user->is_super_admin) {
            return $next($request);
        }

        // 2. Si la iglesia completa fue SUSPENDIDA manualmente por ti (mal uso, etc.)
        if ($user && $user->contract && $user->contract->status === 'suspended') {
            // Permitimos que puedan ir a la pantalla de suspensión o cerrar sesión
            if (!$request->routeIs('cuenta.suspendida') && !$request->routeIs('logout*')) {
                return redirect()->route('cuenta.suspendida');
            }
        }

        // 3. ¡VÍA LIBRE! 
        // No bloqueamos funciones si no han donado o si acabó su mes.
        // Se les permite usar el sistema, y el Dashboard se encargará de mostrarles el aviso del café de forma sutil.
        return $next($request);
    }
}