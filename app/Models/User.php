<?php

namespace App\Models;

use App\Traits\BelongsToTenant; // <-- 1. IMPORTANTE: Agregar el escudo
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    // 2. Limpiamos el 'use' para que no esté repetido
    use HasFactory, Notifiable, HasRoles; 

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'contract_id',
        'paternal_surname',
        'maternal_surname',
        'gender', // <-- Agregado (lo necesitaremos para las estadísticas)
        'marital_status',
        'birthdate',
        'nationality',
        'curp',
        'profile_photo_path',
        'id_front_path',
        'id_back_path',
        'system_role',
        'last_login_at',  
        'last_login_ip',  
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthdate' => 'date',
            'last_login_at' => 'datetime',
        ];
    }

    // --- RELACIONES ---

    public function events()
    {
        return $this->hasMany(Event::class);
    }

public function contract()
    {

        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class)->withPivot('role')->withTimestamps();
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_user');
    }

    // --- ACCESORES ---

    public function getAgeAttribute()
    {
        return $this->birthdate ? $this->birthdate->age : 'N/A';
    }

    // Nombre completo (útil para el Directorio)
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->paternal_surname} {$this->maternal_surname}";
    }

}