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

        // Traemos a las iglesias con sus usuarios
        $iglesiasParaReporte = Contract::withoutGlobalScopes()
            ->with(['users' => function($query) {
                $query->withoutGlobalScopes()->with('subscriptions'); 
            }])
            ->get();

        // Usamos map para transformar los datos de cada iglesia y calcular los totales
        $reporteDiezmos = $iglesiasParaReporte->map(function ($church) use ($precioCafe) {
            $activeDonorsCount = 0;
            
            foreach ($church->users as $user) {
                if ($user->subscribed('cafe_mensual')) { 
                    $activeDonorsCount++;
                }
            }

            // Agregamos las variables calculadas al objeto de la iglesia
            $church->donantes_activos = $activeDonorsCount;
            $church->total_recaudado = $activeDonorsCount * $precioCafe;
            $church->diezmo_a_devolver = $church->total_recaudado * 0.10; // Sacamos el 10%

            return $church;
        })
        ->filter(function ($church) {
            // Filtramos para que SOLO aparezcan las iglesias que ya tengan al menos 1 donante
            return $church->donantes_activos > 0;
        })
        ->sortByDesc('total_recaudado')
        ->values(); // Re-indexamos el arreglo después de filtrar y ordenar

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

    public function destroyChurch($id)
    {
        $church = \App\Models\Contract::findOrFail($id);

        \Illuminate\Support\Facades\DB::transaction(function () use ($church) {
            
            // 1. Limpiar Liturgias y Eventos
            $eventIds = \Illuminate\Support\Facades\DB::table('events')->where('contract_id', $church->id)->pluck('id');
            if ($eventIds->isNotEmpty()) {
                \Illuminate\Support\Facades\DB::table('event_items')->whereIn('event_id', $eventIds)->delete();
            }
            \Illuminate\Support\Facades\DB::table('events')->where('contract_id', $church->id)->delete();

            // 2. Limpiar Plantillas de Liturgia
            if (\Illuminate\Support\Facades\Schema::hasTable('service_templates')) {
                \Illuminate\Support\Facades\DB::table('service_templates')->where('contract_id', $church->id)->delete();
            }

            // 3. Limpiar Relaciones de Usuarios con Grupos y Privilegios
            if (\Illuminate\Support\Facades\Schema::hasTable('groups')) {
                $groupIds = \Illuminate\Support\Facades\DB::table('groups')->where('contract_id', $church->id)->pluck('id');
                if ($groupIds->isNotEmpty()) {
                    \Illuminate\Support\Facades\DB::table('group_user')->whereIn('group_id', $groupIds)->delete();
                }
                \Illuminate\Support\Facades\DB::table('groups')->where('contract_id', $church->id)->delete();
            }
            
            if (\Illuminate\Support\Facades\Schema::hasTable('skills')) {
                $skillIds = \Illuminate\Support\Facades\DB::table('skills')->where('contract_id', $church->id)->pluck('id');
                if ($skillIds->isNotEmpty()) {
                    \Illuminate\Support\Facades\DB::table('skill_user')->whereIn('skill_id', $skillIds)->delete();
                }
                \Illuminate\Support\Facades\DB::table('skills')->where('contract_id', $church->id)->delete();
            }

            // 4. Eliminar Usuarios de la Iglesia
            \Illuminate\Support\Facades\DB::table('users')->where('contract_id', $church->id)->delete();

            // 5. Finalmente, eliminar la Iglesia (Contrato)
            $church->delete();
        });

        return back()->with('success', 'Iglesia y todos sus registros asociados fueron eliminados correctamente.');
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
        // 1. Validamos los datos (El teléfono ahora es opcional)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $user->id, 
            'role' => 'required|in:miembro,admin,pastor',
            'password' => 'nullable|string|min:8', 
        ]);

        // 2. Guardamos los datos básicos
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        $user->role = $request->role;
        $user->is_church_owner = $request->has('is_church_owner');
        
        // 👇 AQUÍ ESTÁ LA LÍNEA NUEVA PARA ACTIVAR AL USUARIO 👇
        $user->is_active_donor = $request->has('is_active_donor');

        // 3. MAGIA: Si lo haces Pastor o Admin, le encendemos los permisos de los menús
        if (in_array($request->role, ['pastor', 'admin']) || $user->is_church_owner) {
            $user->can_manage_finances = true;
            $user->can_manage_members = true;
            $user->can_manage_church = true;
        } else {
            $user->can_manage_finances = false;
            $user->can_manage_members = false;
            $user->can_manage_church = false;
        }

        // 4. Si escribió una contraseña, la actualizamos
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // 5. Redirigimos a la lista de usuarios de esa iglesia
        return redirect()->route('superadmin.churchUsers', $user->contract_id)
                         ->with('success', 'Usuario, privilegios y estatus actualizados correctamente.');
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