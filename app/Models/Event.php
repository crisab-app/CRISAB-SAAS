<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
    'title', 'description', 'type', 'start_time', 'end_time', 'room_id', 'user_id', 'color'
];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Un evento pertenece a un salón
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Un evento es creado por un usuario responsable
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}