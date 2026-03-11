<?php

namespace App\Traits;

use App\Models\Scopes\TenantScope;
use Illuminate\Support\Facades\Auth;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        // 1. Aplicar el filtro automático para lecturas
        static::addGlobalScope(new TenantScope);

        // 2. Inyectar automáticamente el contract_id al crear registros nuevos
        static::creating(function ($model) {
            if (Auth::check() && !$model->contract_id) {
                $model->contract_id = Auth::user()->contract_id;
            }
        });
    }
}