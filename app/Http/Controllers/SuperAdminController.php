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
    // --- GESTIÓN DE USUARIOS ---

    public function editUser(\App\Models\User $user)
    {
        return view('superadmin.users-edit', compact('user'));
    }

    public function updateUser(Request $request, \App\Models\User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Usuario actualizado correctamente.');
    }

    public function updatePassword(Request $request, \App\Models\User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ]);

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return back()->with('success', 'Contraseña cambiada exitosamente.');
    }
}