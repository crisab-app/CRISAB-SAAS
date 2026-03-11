<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function index()
    {
        // Aquí NO usamos el filtro de Tenant porque queremos ver TODO
        $churches = Contract::withCount('users')->get();
        return view('superadmin.index', compact('churches'));
    }

    public function updateStatus(Request $request, Contract $church)
    {
        $church->update(['status' => $request->status]); // status: active, trial, suspended
        return back()->with('success', 'Estatus actualizado');
    }
}