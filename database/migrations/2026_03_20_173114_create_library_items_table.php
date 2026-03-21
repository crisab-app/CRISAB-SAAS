<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('library_items', function (Blueprint $table) {
            $table->id();
            // 🏢 Multitenant: A qué iglesia pertenece este archivo/enlace
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            
            $table->string('title'); // Ej. "Manual de Bautismo" o "Biblia NTV"
            $table->text('description')->nullable();
            
            // 🗂️ Tipo de recurso: 'pdf', 'link', 'video'
            $table->string('type')->default('pdf'); 
            
            // 🔗 Rutas: Una para archivos subidos y otra para enlaces externos
            $table->string('file_path')->nullable(); 
            $table->string('url')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('library_items');
    }
};