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
        // 1. Estadísticas básicas
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

        // 3. Traemos TODOS los usuarios
        $allUsers = User::withoutGlobalScopes()
            ->where('is_super_admin', false)
            ->with(['contract' => function ($query) {
                $query->withoutGlobalScopes();
            }])
            ->latest()
            ->get();

        // =========================================================
        // 4. 💰 MAGIA FINANCIERA: REPORTE SECRETO DE DIEZMOS (CAFÉ)
        // =========================================================
        
        // Pon aquí el precio exacto que le pusiste a tu producto en Stripe (ej. 5.00 USD o 100.00 MXN)
        $precioCafe = 5.00; 

        $reporteDiezmos = Contract::withoutGlobalScopes()
            ->with(['users' => function($query) {
                // Traemos a los usuarios y sus suscripciones para no hacer la base de datos lenta
                $query->withoutGlobalScopes()->with('subscriptions'); 
            }])
            ->get()
            ->map(function ($church) use ($precioCafe) {
                
                // Contamos cuántos usuarios de esta iglesia están pagando el café
                $activeDonorsCount = 0;
                foreach ($church->users as $user) {
                    // Cashier verifica mágicamente si el pago está activo en Stripe
                    if ($user->subscribed('cafe_mensual')) { 
                        $activeDonorsCount++;
                    }
                }

                $church->donantes_activos = $activeDonorsCount;
                $church->total_recaudado = $activeDonorsCount * $precioCafe;
                $church->diezmo_a_devolver = $church->total_recaudado * 0.10; // Sacamos el 10%

                return $church;
            })
            ->filter(function ($church) {
                // Filtramos para que SOLO aparezcan las iglesias que ya tengan al menos 1 donante
                return $church->donantes_activos > 0;
            })
            ->sortByDesc('total_recaudado'); // Ordenamos de las que más donan a las que menos

        return view('superadmin.index', compact('churches', 'totalChurches', 'activeChurches', 'totalUsers', 'allUsers', 'reporteDiezmos', 'precioCafe'));
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
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('superadmin.users.index')->with('success', 'Usuario y contraseña actualizados.');
    }
        
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