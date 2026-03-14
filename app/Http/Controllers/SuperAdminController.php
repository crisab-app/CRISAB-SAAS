<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\User; // Añadimos el modelo User para las estadísticas
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index()
    {
        // 1. Estadísticas Rápidas para el Dashboard
        $totalChurches = Contract::count();
        $activeChurches = Contract::where('status', 'active')->count();
        $totalUsers = User::count();

        // 2. Traemos todas las iglesias con su conteo de usuarios
        // Ordenamos para que las más nuevas salgan primero
        $churches = Contract::withCount('users')->latest()->get();
        
        return view('superadmin.index', compact('churches', 'totalChurches', 'activeChurches', 'totalUsers'));
    }

    public function updateStatus(Request $request, Contract $church)
    {
        // Actualizamos el semáforo (active, trial, suspended)
        $church->update(['status' => $request->status]); 
        
        return back()->with('success', 'Estatus de la iglesia actualizado correctamente.');
    }
    // 1. Nueva función para eliminar la iglesia
    public function destroyChurch(Contract $church)
    {
        // Nota: Dependiendo de tu base de datos, esto borrará la iglesia. 
        // Si tienes borrado en cascada, borrará a sus usuarios también.
        $church->delete();
        return back()->with('success', 'Iglesia eliminada de la plataforma.');
    }

    // 2. Nueva función para ver los usuarios de una iglesia específica
    public function churchUsers(Contract $church)
    {
        // Traemos a todos los usuarios que pertenecen a este contrato/iglesia
        $users = $church->users()->get(); 
        
        return view('superadmin.users', compact('church', 'users'));
    }
}