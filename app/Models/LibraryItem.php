<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id', 
        'title', 
        'description', 
        'type', 
        'category',
        'file_path', 
        'url'
    ];

    // Relación: La iglesia dueña de este recurso
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}