<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'contract_id', // No borres los que ya tenías
        'paternal_surname',
        'maternal_surname',
        'marital_status',
        'birthdate',
        'nationality',
        'curp',
        'profile_photo_path',
        'id_front_path',
        'id_back_path',
        'system_role',
        'last_login_at',  // <-- Agrega esta
        'last_login_ip',  // <-- Y esta
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
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
    // Un usuario puede crear/ser responsable de muchos eventos
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    // Un usuario pertenece a un contrato
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class)->withPivot('role')->withTimestamps();
    }
    // Relación para saber qué privilegios/dones tiene este usuario
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_user');
    }
    // Atributo virtual para calcular la edad en tiempo real
    // En app/Models/User.php
    public function getAgeAttribute()
    {
        // Si no hay fecha de nacimiento, devolvemos "N/A" o 0 en lugar de un error
        return $this->birthdate ? $this->birthdate->age : 'N/A';
    }
}
