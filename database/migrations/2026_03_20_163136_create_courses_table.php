<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            // 🏢 Multitenant: A qué iglesia pertenece este curso
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            
            // 👨‍🏫 El Maestro (es un miembro de la iglesia)
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
            
            // 📖 Datos del Curso
            $table->string('name'); // Ej. "Nuevos Creyentes"
            $table->text('description')->nullable();
            $table->string('schedule')->nullable(); // Ej. "Domingos 10:00 AM"
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            // 🟢 Estado: 'active' (abierto) o 'closed' (terminado)
            $table->string('status')->default('active'); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};