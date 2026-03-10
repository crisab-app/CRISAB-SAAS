<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ChurchRegistrationController extends Controller
{
    // 1. Mostrar el formulario público de registro de nueva iglesia
    public function create()
    {
        return view('auth.register_church');
    }

    // 2. Procesar el formulario y crear la cuenta
    public function store(Request $request)
    {
        // Validamos que vengan los datos de la iglesia y del pastor
        $request->validate([
            'church_name' => 'required|string|max:255',
            'pastor_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // A. Creamos la nueva Iglesia (Contrato)
        $contract = Contract::create([
            'name' => $request->church_name,
            // Si tu tabla contracts requiere otros campos por defecto (como un slug), agrégalos aquí. 
            // Por ejemplo: 'status' => 'active'
        ]);

        // B. Creamos al usuario (Pastor/Admin) amarrado a esa nueva iglesia
        $user = User::create([
            'name' => $request->pastor_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contract_id' => $contract->id, // ¡Aquí ocurre la magia de la conexión!
            // Le asignamos por defecto datos básicos para que no truene la validación
            'birthdate' => now(), 
            'nationality' => 'México',
        ]);

        // C. Iniciamos sesión automáticamente con este nuevo usuario
        Auth::login($user);

        // D. Lo mandamos directo a su nuevo panel de control
        return redirect()->route('dashboard')->with('success', '¡Bienvenido! El espacio para tu iglesia ha sido creado con éxito.');
    }
}