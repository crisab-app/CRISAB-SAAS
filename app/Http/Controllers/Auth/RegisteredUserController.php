<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Contract; // <-- Importamos el modelo de la iglesia
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Hacemos que proporcione correo O teléfono (al menos uno de los dos)
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20', 'unique:'.User::class], // Exigimos el teléfono
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'church_name' => ['required', 'string', 'max:255'],
        ]);

        // 1. CREAMOS LA IGLESIA PRIMERO
        $contract = Contract::create([
            'name' => $request->church_name,
            'status' => 'active', // O 'trial' si luego les darás días de prueba
        ]);

        // 2. CREAMOS AL USUARIO Y LO AMARRAMOS A ESA IGLESIA
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'contract_id' => $contract->id, // ¡El candado mágico!
            'is_church_owner' => true, // Asignamos el rol de pastor al registrarse
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}