<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['contract_id', 'name', 'description'];

    // Un grupo pertenece a una iglesia (Contrato)
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    // Un grupo tiene muchos miembros con distintos cargos
    public function members()
    {
        return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();
    }
}