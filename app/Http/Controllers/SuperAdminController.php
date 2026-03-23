<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 

class SuperAdminController extends Controller
{
    public function index()
    {
        // 1. Estadísticas (Sin papelera)
        $totalChurches = Contract::withoutGlobalScopes()->count();
        $activeChurches = Contract::withoutGlobalScopes()->where('status', 'active')->count();
        $totalUsers = User::withoutGlobalScopes()->where('is_super_admin', false)->count();

        // 2. Traemos TODAS las iglesias 
        $churches = Contract::withoutGlobalScopes()
            ->withCount(['users' => function ($query) {
                $query->withoutGlobalScopes();
            }])
            ->latest()
            ->get();        

        // 3. Traemos TODOS los usuarios (Para que puedas verlos y modificarlos)
        $allUsers = User::withoutGlobalScopes()
            ->where('is_super_admin', false) // Excluimos a tu cuenta Master
            ->with(['contract' => function ($query) {
                $query->withoutGlobalScopes();
            }])
            ->latest()
            ->get();
        
        return view('superadmin.index', compact('churches', 'totalChurches', 'activeChurches', 'totalUsers', 'allUsers'));
    }

    // ==========================================
    // --- GESTIÓN DE IGLESIAS (CONTRATOS) ---
    // ==========================================

    public function updateStatus(Request $request, Contract $church)
    {
        $church->update(['status' => $request->status]); 
        return back()->with('success', 'Estatus de la iglesia actualizado correctamente.');
    }

    public function editChurch(Contract $church)
    {
        return view('superadmin.church-edit', compact('church'));
    }

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

    public function destroyChurch(Contract $church)
    {
        // Borramos usuarios ignorando los scopes
        User::withoutGlobalScopes()->where('contract_id', $church->id)->delete();
        $church->delete();
        
        return back()->with('success', 'Iglesia y todos sus usuarios eliminados permanentemente.');
    }

    // ==========================================
    // --- GESTIÓN DE USUARIOS ---
    // ==========================================

    public function churchUsers(Contract $church)
    {
        // Listamos usuarios de esa iglesia usando rayos X
        $users = User::withoutGlobalScopes()->where('contract_id', $church->id)->get(); 
        return view('superadmin.users', compact('church', 'users'));
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'Usuario eliminado de la plataforma.');
    }

    public function editUser(User $user)
    {
        return view('superadmin.users-edit', compact('user'));
    }

public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:miembro,admin,pastor',
        ]);

        // Guardamos los datos básicos y el rol
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        
        // Verificamos si marcaste la casilla de "Dueño"
        $user->is_church_owner = $request->has('is_church_owner');

        // MAGIA: Si lo haces Pastor o Admin, le encendemos los permisos de los menús
        if (in_array($request->role, ['pastor', 'admin']) || $user->is_church_owner) {
            $user->can_manage_finances = true;
            $user->can_manage_members = true;
            $user->can_manage_church = true;
        }

        $user->save();

        return redirect()->route('superadmin.churchUsers', $user->contract_id)
                         ->with('success', 'Usuario y privilegios actualizados correctamente.');
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