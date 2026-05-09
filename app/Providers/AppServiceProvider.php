<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail; // Se agregó esta importación
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
        // 🚀 1. TRADUCCIÓN DEL CORREO DE RECUPERACIÓN DE CONTRASEÑA
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            // Construimos el enlace seguro
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('🔐 Recuperación de Contraseña - administrarme.com')
                ->greeting('¡Hola, ' . $notifiable->name . '!')
                ->line('Estás recibiendo este correo porque recibimos una solicitud para restablecer la contraseña de tu cuenta en administrarme.com.')
                ->action('Restablecer Contraseña', $url)
                ->line('Este enlace de recuperación caducará en 60 minutos por motivos de seguridad.')
                ->line('Si tú no solicitaste este cambio, no es necesario que realices ninguna acción. Tu cuenta sigue estando segura.')
                ->salutation('Bendiciones, el equipo de administrarme.com');
        });

        // 📧 2. TRADUCCIÓN DEL CORREO DE VERIFICACIÓN DE CUENTA
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('✅ Verifica tu cuenta - administrarme.com')
                ->greeting('¡Hola, ' . $notifiable->name . '!')
                ->line('¡Gracias por registrarte en administrarme.com! Antes de comenzar, necesitamos que confirmes tu dirección de correo electrónico.')
                ->line('Haz clic en el botón de abajo para activar tu cuenta y acceder a todas las herramientas de administración.')
                ->action('Verificar mi cuenta', $url)
                ->line('Si no creaste esta cuenta, simplemente ignora este mensaje.')
                ->salutation('Bendiciones, el equipo de administrarme.com');
        });

        // 🔒 3. FORZAR HTTPS EN PRODUCCIÓN
        // Usamos config() en lugar de env() directamente para mayor estabilidad
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}