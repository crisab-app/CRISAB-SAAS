<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('library_items', function (Blueprint $table) {
            // Agregamos la columna categoría (por defecto serán Libros)
            $table->string('category')->default('Libros de Consulta')->after('type');
        });
    }

    public function down()
    {
        Schema::table('library_items', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};