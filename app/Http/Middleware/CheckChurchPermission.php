<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckChurchPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next) {
    $user = auth()->user();
    if ($user && ($user->is_super_admin || $user->can_manage_church)) {
        return $next($request);
    }
    abort(403, '🔒 Acceso Denegado: Solo el Administrador Principal puede modificar el perfil de la iglesia.');
}}
