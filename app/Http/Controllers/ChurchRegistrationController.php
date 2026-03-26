<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeChurchMail;
use App\Mail\AdminNotificationMail;

class ChurchRegistrationController extends Controller
{
    // 1. Mostrar el formulario público de registro de nueva iglesia
    public function create()
    {
        return view('auth.register_church'); // Asegúrate de que el nombre de esta vista coincida con tu archivo
    }

    // 2. Procesar el formulario y crear la cuenta
    public function store(Request $request)
    {
        // Validamos los datos: Teléfono OBLIGATORIO, Correo OPCIONAL
        $request->validate([
            'church_name' => 'required|string|max:255',
            'pastor_name' => 'required|string|max:255',
            'phone'       => 'required|string|max:20|unique:users', // Exigimos el teléfono y que no esté repetido
            'email'       => 'nullable|string|email|max:255|unique:users', // El correo ahora es opcional
            'password'    => 'required|string|min:8|confirmed',
            'terms'       => 'accepted', // Validamos que hayan marcado la casilla de términos
        ]);

        // A. Creamos la nueva Iglesia (Contrato)
        $contract = Contract::create([
            'name' => $request->church_name,
            'status' => 'active', // Nos aseguramos de que la iglesia nazca activa
        ]);

        // B. Creamos al usuario amarrado a esa nueva iglesia
        $user = User::create([
            'name' => $request->pastor_name,
            'phone' => $request->phone,   // Guardamos el teléfono
            'email' => $request->email,   // Guardamos el correo (aunque venga vacío)
            'password' => Hash::make($request->password),
            'contract_id' => $contract->id, // ¡Aquí ocurre la magia de la conexión!
            
            // 🔥 LE DAMOS EL PODER ABSOLUTO DESDE EL DÍA 1
            'is_church_owner' => true,
            'role' => 'pastor',
            'can_manage_finances' => true,
            'can_manage_members' => true,
            'can_manage_church' => true,

            // Le asignamos por defecto datos básicos para que no truene la validación en otras pantallas
            'birthdate' => now(), 
            'nationality' => 'México',
        ]);
        
        // A. Notificar al sistema SIEMPRE que haya un registro
        Mail::to('administrarme@crisab.com')->send(new AdminNotificationMail($user, $contract->name));

        // B. Enviar Bienvenida y Manual al Pastor (SOLO SI DEJÓ CORREO)
        if ($user->email) {
            Mail::to($user->email)->send(new WelcomeChurchMail($user, $contract->name));
        }

        // C. Iniciamos sesión automáticamente con este nuevo usuario
        Auth::login($user);

        // D. Lo mandamos directo a su nuevo panel de control
        return redirect()->route('dashboard')->with('success', '¡Bienvenido! El espacio para tu iglesia ha sido creado con éxito.');
    }
}