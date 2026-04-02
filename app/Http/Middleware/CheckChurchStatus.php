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

        // 1. Si es el SuperAdmin, lo dejamos pasar a donde quiera
        if ($user->is_super_admin) {
            return $next($request);
        }

        // 2. Si el usuario NO ha invitado su café (is_active_donor es false)
        // Y NO está intentando acceder a la página de pago, lo redirigimos a pagar.
        if (!$user->is_active_donor && !$request->routeIs('cafe.*') && !$request->routeIs('logout.get')) {
            // Aquí puedes decidir: 
            // O lo mandas a una vista que diga "Tu prueba expiró, paga aquí" (ej. view('errors.suspended'))
            // O lo mandas directo a la pantalla bonita del café:
            return redirect()->route('cafe.index')->with('warning', 'Para continuar usando AdministrarMe, por favor activa tu cuenta invitándonos un café.');
        }

        // 3. Si ya pagó, lo dejamos pasar libremente
        return $next($request);
    }
}