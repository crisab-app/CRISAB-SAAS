<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete(); // Pertenece a un evento del calendario
            $table->string('name'); // Ej. "Alabanza y Adoración"
            $table->foreignId('skill_id')->constrained(); // El privilegio necesario (Música, Predicación, etc.)
            $table->integer('order_index'); // Para saber qué va primero
            $table->foreignId('user_id')->nullable()->constrained(); // ¡Aquí asignaremos a la persona real después!
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_items');
    }
};