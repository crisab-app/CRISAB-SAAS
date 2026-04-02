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

        // 1. Si es el SuperAdmin, pasa directo
        if ($user && $user->is_super_admin) {
            return $next($request);
        }

        // 2. Si la iglesia completa fue SUSPENDIDA por ti (mal uso, etc.), sí los bloqueamos
        if ($user && $user->contract && $user->contract->status === 'suspended') {
            if (!$request->routeIs('cuenta.suspendida') && !$request->routeIs('logout.get')) {
                return redirect()->route('cuenta.suspendida');
            }
        }

        // 3. ¡VÍA LIBRE! Ya no bloqueamos si no han donado. 
        // Dejamos que usen el sistema con los privilegios que tengan.
        return $next($request);
    }
}