<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'coordinates'];

    // Un contrato tiene muchos usuarios
    public function users()
    {
        return $this->hasMany(User::class);
    }
}