<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $fillable = ['name', 'capacity', 'color'];

    // Un salón puede tener muchos eventos
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}