<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 🚨 REGLA DE ORO: Si no ha iniciado sesión, o SI NO TIENE la bandera de super_admin, lo pateamos.
        if (!auth()->check() || auth()->user()->is_super_admin !== 1) {
            
            // Opción A: Mandarlo a un error 403 (Prohibido)
            abort(403, 'Acceso Denegado. Solo personal autorizado.');
            
            // Opción B (Más sigilosa): Fingir que la página no existe (Error 404) para que los hackers no sepan que hay un panel maestro aquí.
            // abort(404);
        }

        return $next($request);
    }
}