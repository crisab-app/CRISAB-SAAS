<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    use HasFactory;

    // Aquí está el arreglo: Cambiamos 'title' por 'name' y 'order' por 'order_index'
    // para que coincida exactamente con lo que envía el Controlador en la función storeItem
    protected $fillable = [
        'service_template_id',
        'name',
        'description',
        'duration_minutes',
        'order_index',
        'skill_id',
    ];

    // Relación con la plantilla
    public function template()
    {
        return $this->belongsTo(ServiceTemplate::class, 'service_template_id');
    }

    // Relación con el ministerio/habilidad requerido
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}