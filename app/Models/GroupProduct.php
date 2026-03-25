<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupProduct extends Model
{
    // Agregamos 'barcode' a los campos permitidos
    protected $fillable = ['group_id', 'barcode', 'name', 'cost_price', 'sale_price', 'stock'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}