<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChurchProfileController extends Controller
{
    public function edit()
    {
        // Traemos los datos de la iglesia a la que pertenece el usuario actual
        $church = Auth::user()->contract; 
        
        return view('church.profile', compact('church'));
    }

    public function update(Request $request)
    {
        $church = Auth::user()->contract;

        // Validamos que suban imágenes reales, URLs válidas y la nueva Zona Horaria
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096', // Max 4MB
            'history' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'timezone' => 'required|string', // <-- ¡Validamos la zona horaria!
        ]);

        // 1. Si subió un Logo Nuevo, lo guardamos y borramos el anterior (si existía)
        if ($request->hasFile('logo')) {
            if ($church->logo_path) {
                Storage::disk('public')->delete($church->logo_path);
            }
            $church->logo_path = $request->file('logo')->store('church_logos', 'public');
        }

        // 2. Si subió una Foto de Portada, hacemos lo mismo
        if ($request->hasFile('cover_photo')) {
            if ($church->cover_photo_path) {
                Storage::disk('public')->delete($church->cover_photo_path);
            }
            $church->cover_photo_path = $request->file('cover_photo')->store('church_covers', 'public');
        }

        // 3. Guardamos los textos, redes sociales y LA ZONA HORARIA
        $church->fill($request->only([
            'history', 'contact_email', 'contact_phone', 'facebook_url', 'youtube_url', 'timezone' // <-- ¡Agregado aquí!
        ]));
        
        $church->save();

        return back()->with('success', '¡Perfil de la iglesia actualizado con éxito!');
    }
}