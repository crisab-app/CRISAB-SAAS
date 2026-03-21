<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // El Alumno
            
            // Estado del alumno: 'enrolled' (cursando), 'graduated' (graduado), 'dropped' (baja)
            $table->string('status')->default('enrolled'); 
            $table->date('enrollment_date')->useCurrent();
            $table->date('completion_date')->nullable(); // Fecha en la que se graduó
            
            $table->timestamps();
            
            // Evitamos que un alumno se inscriba dos veces al mismo curso al mismo tiempo
            $table->unique(['course_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_user');
    }
};