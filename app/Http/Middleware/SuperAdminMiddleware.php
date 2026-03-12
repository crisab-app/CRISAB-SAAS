<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Revisamos quién está intentando entrar
        $user = Auth::user();

        // Jalamos tus correos maestros del servidor
        $superAdmin = env('SUPER_ADMIN_EMAIL');
        $localAdmin = env('LOCAL_ADMIN_EMAIL');

        // Si el correo del usuario NO es ninguno de los tuyos, lo pateamos al dashboard normal
        if ($user->email !== $superAdmin && $user->email !== $localAdmin) {
            return redirect('/dashboard')->with('error', 'No tienes permisos de CEO para ver esta sección.');
        }

        // Si sí eres tú, lo dejamos pasar al panel
        return $next($request);
    }
}