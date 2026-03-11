<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class EventItem extends Model
{
    use BelongsToTenant;
    protected $fillable = ['event_id', 'name', 'skill_id', 'order_index', 'user_id', 'details'];

    public function event() {
        return $this->belongsTo(Event::class);
    }

    // Para saber quién fue asignado a este bloque
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Para saber qué privilegio/habilidad se requiere
    public function skill() {
        return $this->belongsTo(Skill::class);
    }
}