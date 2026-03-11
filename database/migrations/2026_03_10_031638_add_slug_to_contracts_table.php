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
        // Validamos si la columna 'slug' NO existe antes de intentar crearla
        if (!Schema::hasColumn('contracts', 'slug')) {
            Schema::table('contracts', function (Blueprint $table) {
                $table->string('slug')->unique()->nullable()->after('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            // Validamos si existe para poder borrarla de forma segura
            if (Schema::hasColumn('contracts', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};