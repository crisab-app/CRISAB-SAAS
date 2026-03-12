<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index()
    {
        // Traemos todas las iglesias y contamos cuántos usuarios tiene cada una
        $churches = Contract::withCount('users')->get();
        
        return view('superadmin.index', compact('churches'));
    }

    public function updateStatus(Request $request, Contract $church)
    {
        // Actualizamos el semáforo (active, trial, suspended)
        $church->update(['status' => $request->status]); 
        
        return back()->with('success', 'Estatus actualizado correctamente.');
    }
}