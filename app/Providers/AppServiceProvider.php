<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Muy importante agregar esta línea
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🚀 MAGIA PARA TRADUCIR EL CORREO DE RECUPERACIÓN
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            
            // 1. Construimos el enlace seguro de Laravel
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            // 2. Armamos el correo 100% en español y personalizado
            return (new MailMessage)
                ->subject('🔐 Recuperación de Contraseña - administrarme.com')
                ->greeting('¡Hola, ' . $notifiable->name . '!')
                ->line('Estás recibiendo este correo porque recibimos una solicitud para restablecer la contraseña de tu cuenta en administrarme.com.')
                ->action('Restablecer Contraseña', $url)
                ->line('Este enlace de recuperación caducará en 60 minutos por motivos de seguridad.')
                ->line('Si tú no solicitaste este cambio, no es necesario que realices ninguna acción. Tu cuenta sigue estando segura.')
                ->salutation('Bendiciones, el equipo de administrarme.com');
        });
        // Forzar HTTPS si estamos en el servidor de producción
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
}