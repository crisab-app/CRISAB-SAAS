<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonationController extends Controller
{
    // 1. Mostrar la pantalla bonita del café
    public function index()
    {
        return view('cafe.index');
    }

    // 2. Procesar el pago VOLUNTARIO (Único) y enviar a Stripe
    public function checkout(Request $request)
    {
        // ⚠️ RECUERDA CAMBIAR ESTO POR TU NUEVO CÓDIGO DE PAGO ÚNICO
        $priceId = 'price_1TE8ONDkKagBvgg5Km7PRdJH'; 

        // Usamos checkout directo para un pago voluntario de una sola vez
        return $request->user()->checkout([$priceId => 1], [
            'success_url' => route('dashboard') . '?cafe=gracias',
            'cancel_url' => route('cafe.index'),
        ]);
    }
}