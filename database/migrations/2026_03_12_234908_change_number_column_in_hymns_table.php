<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hymns', function (Blueprint $table) {
            // Cambiamos de integer a string para que acepte "536a"
            $table->string('number')->change();
        });
    }

    public function down(): void
    {
        Schema::table('hymns', function (Blueprint $table) {
            $table->integer('number')->change();
        });
    }
};