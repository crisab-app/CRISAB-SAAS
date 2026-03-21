<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id', 'teacher_id', 'name', 'description', 
        'schedule', 'start_date', 'end_date', 'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relación: La iglesia dueña del curso
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    // Relación: El maestro asignado
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Relación: Los alumnos inscritos
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user')
                    ->withPivot('status', 'enrollment_date', 'completion_date')
                    ->withTimestamps();
    }
}