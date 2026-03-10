<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Contract extends Model
{
    use HasFactory;

    // 1. Agregamos 'slug' a los campos que se pueden llenar
    protected $fillable = ['name', 'address', 'coordinates', 'slug'];

    /**
     * Lógica Automática (Cerebro del Modelo)
     * Esto genera el "slug" basado en el nombre de la iglesia 
     * justo antes de guardarla en la base de datos.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contract) {
            // Si el slug viene vacío, lo creamos a partir del nombre
            if (empty($contract->slug)) {
                $contract->slug = Str::slug($contract->name);
            }
        });
    }

    // --- RELACIONES ---

    // Un contrato (iglesia) tiene muchos usuarios/miembros
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Un contrato tiene sus propios grupos (Sociedades)
    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    // Habilidades o Privilegios específicos de esta iglesia
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    // El calendario de eventos de esta iglesia
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}