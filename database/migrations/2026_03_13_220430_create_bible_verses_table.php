<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bible_verses', function (Blueprint $table) {
            $table->id();
            $table->string('book_name'); // Ej: "Génesis"
            $table->integer('chapter');  // Ej: 1
            $table->integer('verse');    // Ej: 1
            $table->text('text');        // "En el principio creó Dios..."
            
            // Añadimos índices para que las búsquedas sean ultra rápidas
            $table->index(['book_name', 'chapter']);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bible_verses');
    }
};