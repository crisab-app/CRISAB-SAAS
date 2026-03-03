<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // Los campos que el formulario puede llenar
    protected $fillable = ['contract_id', 'title', 'start', 'end', 'description'];

    // Le decimos que cada evento pertenece a una iglesia (contract)
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}