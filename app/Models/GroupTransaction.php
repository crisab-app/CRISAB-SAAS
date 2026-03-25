<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTransaction extends Model
{
    protected $fillable = ['group_id', 'user_id', 'type', 'total'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un ticket tiene muchos productos dentro
    public function items()
    {
        return $this->hasMany(GroupTransactionItem::class);
    }
}