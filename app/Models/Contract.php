<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Contract extends Model
{
    use HasFactory;
    // 🚨 AQUÍ ELIMINAMOS EL `use BelongsToTenant;` QUE ESTABA CAUSANDO EL PROBLEMA 🚨

    // 1. Agregamos 'slug' a los campos que se pueden llenar
    protected $fillable = [
        'name',
        'status', // El que agregamos para activo/suspendido
        // --- LOS CAMPOS NUEVOS DEL PERFIL ---
        'logo_path',
        'cover_photo_path',
        'history',
        'contact_email',
        'contact_phone',
        'address',
        'facebook_url',
        'youtube_url',
    ];
    /**
     * Determina si la iglesia aún está en su mes de regalo.
     */
    public function isWithinTrialPeriod()
    {
        // Si la iglesia tiene menos de 30 días de creada, es periodo de gracia
        return $this->created_at->diffInDays(now()) <= 30;
    }
    /**
     * Determina si debe mostrarse el aviso del café.
     */
    public function needsCoffeeContribution()
    {
        // Si ya pasó el mes Y no tiene un estatus de 'active' (pagado/VIP)
        return !$this->isWithinTrialPeriod() && $this->status !== 'active';
    }

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