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

    // 2. Procesar el pago y enviar a Stripe
    public function checkout(Request $request)
    {
        // Tu código mágico de Stripe
        $priceId = 'price_1TE8ONDkKagBvgg5Km7PRdJH'; 

        // Usamos Cashier para crear la suscripción y redirigir al pago seguro
        return $request->user()
            ->newSubscription('cafe_mensual', $priceId)
            ->checkout([
                'success_url' => route('dashboard') . '?cafe=gracias', // A dónde va si paga con éxito
                'cancel_url' => route('cafe.index'), // A dónde va si se arrepiente
            ]);
    }
}