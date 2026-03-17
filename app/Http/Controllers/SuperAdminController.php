<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Agregamos esto para las contraseñas

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

    // ==========================================
    // --- GESTIÓN DE IGLESIAS (CONTRATOS) ---
    // ==========================================

    // Actualización rápida del semáforo desde la lista (si lo sigues usando)
    public function updateStatus(Request $request, Contract $church)
    {
        $church->update(['status' => $request->status]); 
        return back()->with('success', 'Estatus de la iglesia actualizado correctamente.');
    }

    // Mostrar pantalla de edición completa de la iglesia
    public function editChurch(Contract $church)
    {
        return view('superadmin.church-edit', compact('church'));
    }

    // Guardar los cambios del nombre o estatus de la iglesia
    public function updateChurch(Request $request, Contract $church)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,suspended,trial',
        ]);

        $church->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect('/master-panel')->with('success', 'Iglesia actualizada correctamente.');
    }

    // Eliminar una iglesia por completo
    // Eliminar una iglesia por completo (y sus usuarios)
    public function destroyChurch(\App\Models\Contract $church)
    {
        // 1. Primero borramos a todos los usuarios de esta iglesia para que no queden "huérfanos"
        $church->users()->delete();
        
        // 2. Ahora sí, borramos la iglesia
        $church->delete();
        
        return back()->with('success', 'Iglesia y todos sus usuarios eliminados permanentemente.');
    }

    // Eliminar un solo usuario
    public function destroyUser(\App\Models\User $user)
    {
        $user->delete();
        return back()->with('success', 'Usuario eliminado de la plataforma.');
    }

    // Ver los usuarios de una iglesia específica
    public function churchUsers(Contract $church)
    {
        // Traemos a todos los usuarios que pertenecen a este contrato/iglesia
        $users = $church->users()->get(); 
        
        return view('superadmin.users', compact('church', 'users'));
    }


    // ==========================================
    // --- GESTIÓN DE USUARIOS ---
    // ==========================================

    public function editUser(User $user)
    {
        return view('superadmin.users-edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
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

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Contraseña cambiada exitosamente.');
    }
}