<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventItem extends Model
{
    // QUITAMOS el "use BelongsToTenant" de aquí adentro
    
    protected $fillable = [
        'event_id', 
        'name', 
        'skill_id', 
        'order_index', 
        'user_id', 
        'details'
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function skill() {
        return $this->belongsTo(Skill::class);
    }
}