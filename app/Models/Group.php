<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['contract_id', 'name', 'description'];

    // 1. Generar el código secreto automáticamente al crear el grupo
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    // 2. ¡ESTA ES LA LÍNEA MÁGICA! Le dice a Laravel que use 'uuid' en lugar del número (4)
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();
    }
}