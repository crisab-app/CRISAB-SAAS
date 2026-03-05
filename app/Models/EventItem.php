<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventItem extends Model
{
    protected $fillable = ['event_id', 'name', 'skill_id', 'order_index', 'user_id'];

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