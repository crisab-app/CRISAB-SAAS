<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hymns', function (Blueprint $table) {
            $table->id();
            $table->integer('number'); // El número del himno
            $table->string('title');   // El título
            $table->string('tune')->nullable(); // El ritmo o nota
            $table->string('youtube_link')->nullable(); // Aquí guardaremos los links después
            $table->longText('lyrics')->nullable();     // Aquí guardaremos la letra después
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hymns');
    }
};