<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckChurchStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verificamos si el usuario tiene sesión iniciada y tiene una iglesia
        if (auth()->check() && auth()->user()->contract) {
            
            $status = auth()->user()->contract->status;

            // 2. Si están SUSPENDIDOS, los mandamos a la cárcel (excepto si quieren cerrar sesión)
            if ($status === 'suspended') {
                if ($request->routeIs('cuenta.suspendida') || $request->routeIs('logout')) {
                    return $next($request); // Déjalo pasar a ver el aviso o salir
                }
                return redirect()->route('cuenta.suspendida');
            }
        }

        return $next($request); // Si todo está bien, déjalo pasar normalmente
    }
}