<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use BelongsToTenant;

 protected $fillable = [
        'contract_id', 
        'user_id', 
        'title', 
        'description', 
        'start', 
        'end', 
        'color', 
        'status',
        'visibility',        
        'preaching_topic',   
        'liturgy_details',   
        'attendance_count',
        'sermon_notes' // <-- ¡Agregamos esta línea!
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function items()
    {
        return $this->hasMany(EventItem::class)->orderBy('order_index');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}