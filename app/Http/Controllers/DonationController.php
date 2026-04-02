<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;

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
        // Tu ID del producto en vivo
        $priceId = 'price_1THDlLDkKagBvgg5X5u489Gl'; 

        return $request->user()->checkout([$priceId => 1], [
            'success_url' => route('dashboard') . '?cafe=gracias',
            'cancel_url' => route('cafe.index'),
        ]);
    }

    // 3. Webhook para escuchar a Stripe
    public function webhook(Request $request)
    {
        // Obtenemos el secreto de Coolify
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $event = null;

        try {
            // Validamos que el mensaje realmente venga de Stripe
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Payload inválido
            Log::error('Stripe Webhook: Payload inválido.');
            return response()->json(['error' => 'Payload inválido'], 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Firma inválida (Alguien intentó hackear el endpoint)
            Log::error('Stripe Webhook: Firma inválida.');
            return response()->json(['error' => 'Firma inválida'], 400);
        }

        // Manejar el evento específico de pago exitoso
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            
            // Laravel Cashier envía automáticamente el ID del usuario en client_reference_id
            $userId = $session->client_reference_id; 
            
            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    // 🎉 ¡PAGO EXITOSO!
                    // Aquí el usuario ya pagó. Dejamos un log en el sistema.
                    Log::info("🎉 ¡El usuario {$user->name} de la iglesia {$user->contract->name} ha invitado un café!");
                    
                    // Opcional: Si en el futuro creas una tabla 'donations' o un campo en 'users',
                    // lo actualizas aquí. Ejemplo:
                    // $user->coffee_donations += 1;
                    // $user->save();
                }
            }
        }

        // Le respondemos a Stripe con un 200 OK para que sepa que recibimos el mensaje
        return response()->json(['status' => 'success'], 200);
    }
}