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
}