<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['contract_id', 'name', 'description'];

    // Generar UUID automático
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    // Usar UUID en la URL en lugar del número
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}