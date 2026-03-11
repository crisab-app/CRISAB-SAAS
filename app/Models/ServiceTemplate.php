<?php
namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServiceTemplate extends Model
{
    use BelongsToTenant;
    protected $fillable = ['contract_id', 'name', 'description'];

    protected static function boot() {
        parent::boot();
        static::creating(function ($model) { $model->uuid = (string) Str::uuid(); });
    }

    public function getRouteKeyName() { return 'uuid'; }

    // Una plantilla pertenece a tu iglesia
    public function contract() { return $this->belongsTo(Contract::class); }
    
    // Una plantilla tiene muchos bloques
    public function items() { return $this->hasMany(ServiceItem::class)->orderBy('order_index'); }
}