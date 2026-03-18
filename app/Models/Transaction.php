<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // AQUÍ ESTÁ LA CLAVE: Agregamos 'person_name' a la lista de permisos
    protected $fillable = [
        'contract_id', 'fund_id', 'user_id', 'type', 
        'category', 'person_name', 'amount', 'date', 'description', 'status'
    ];

    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}