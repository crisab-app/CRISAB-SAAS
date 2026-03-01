<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    protected $fillable = ['service_template_id', 'skill_id', 'name', 'order_index'];

    // Este bloque pertenece a una plantilla
    public function template() { return $this->belongsTo(ServiceTemplate::class, 'service_template_id'); }

    // Este bloque requiere un privilegio en específico (opcional)
    public function skill() { return $this->belongsTo(Skill::class); }
}