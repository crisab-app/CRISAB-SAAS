<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; 
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;

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
        // Forzar HTTPS cuando estemos en internet (producción)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }// 2. Agrega este bloque de código
        // Si el sistema detecta que está en internet (producción), fuerza el candado HTTPS
        Event::listen(function (Login $event) {
            $event->user->update([
                'last_login_at' => now(),
                'last_login_ip' => request()->ip(),
            ]);
        });
        //
    }
}
