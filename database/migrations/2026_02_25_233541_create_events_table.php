<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Ej: Culto de Jóvenes, Boda de Ana y Juan
        $table->text('description')->nullable(); // Detalles del evento
        $table->string('type')->default('reunion'); // culto, boda, retiro, etc.
        $table->dateTime('start_time'); // Cuándo empieza
        $table->dateTime('end_time'); // Cuándo termina
        
        // Relacionamos el evento con un salón (puede ser nulo si es un evento externo)
        $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
        
        // Relacionamos el evento con el responsable (Usuario)
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
