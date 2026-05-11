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
        return view('auth.register');
    }

    // 2. Procesar el formulario y crear la cuenta
    public function store(Request $request)
    {
        // 🚀 BLOQUEO DE BOTS (HONEYPOT)
        // Si el campo invisible tiene algún texto, matamos la petición inmediatamente con un error 403.
        if ($request->filled('work_email_address')) {
            abort(403, 'Actividad automatizada sospechosa detectada.');
        }

        // Validamos los datos, incluyendo el Captcha de seguridad
        $request->validate([
            'church_name' => 'required|string|max:255',
            'name'        => 'required|string|max:255',
            'phone'       => 'required|string|max:20|unique:users',
            'email'       => 'nullable|string|email|max:255|unique:users',
            'password'    => 'required|string|min:8|confirmed',
            'terms'       => 'accepted',
            'captcha'     => 'required|captcha', // 🔥 VALIDACIÓN DEL CAPTCHA
        ], [
            // Mensaje personalizado en español si fallan el captcha
            'captcha.captcha' => 'El código de seguridad de la imagen es incorrecto. Por favor, intenta de nuevo.',
        ]);

        // A. Creamos la nueva Iglesia (Contrato)
        $contract = Contract::create([
            'name' => $request->church_name,
            'status' => 'trial', // Nos aseguramos de que la iglesia nazca en modo de prueba
        ]);

        // B. Creamos al usuario amarrado a esa nueva iglesia
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,   
            'email' => $request->email,   
            'password' => Hash::make($request->password),
            'contract_id' => $contract->id, 
            
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
        
        // C. Notificar al sistema SIEMPRE que haya un registro
        Mail::to('administrarme@crisab.com')->send(new AdminNotificationMail($user, $contract->name));

        // D. Enviar Bienvenida y Manual al Pastor (SOLO SI DEJÓ CORREO)
        if ($user->email) {
            Mail::to($user->email)->send(new WelcomeChurchMail($user, $contract->name));
        }

        // E. Iniciamos sesión automáticamente con este nuevo usuario
        Auth::login($user);

        // F. Lo mandamos directo a su nuevo panel de control
        return redirect()->route('dashboard')->with('success', '¡Bienvenido! El espacio para tu iglesia ha sido creado con éxito.');
    }
}