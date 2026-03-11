<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (Auth::check()) {
            // Jalamos los correos secretos desde el archivo .env
            $superAdmin = env('SUPER_ADMIN_EMAIL');
            $localAdmin = env('LOCAL_ADMIN_EMAIL');

            // Si el usuario actual NO eres tú...
            if (Auth::user()->email !== $superAdmin && Auth::user()->email !== $localAdmin) {
                
                // Le aplicamos el candado de su iglesia. 
                // Usamos getTable() para evitar errores si hacemos consultas complejas después.
                $builder->where($model->getTable() . '.contract_id', Auth::user()->contract_id);
                
                // NOTA FUTURA: Aquí mismo agregaremos la lógica para la "Misión Bíblica Mexicana"
                // para que, si es una "Sede", pueda ver los contract_id de sus iglesias hijas.
            }
        }
    }
}