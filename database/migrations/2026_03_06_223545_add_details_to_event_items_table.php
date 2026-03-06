<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_items', function (Blueprint $table) {
            // Agregamos la columna para escribir los detalles (canciones, pasajes, etc.)
            if (!Schema::hasColumn('event_items', 'details')) {
                $table->text('details')->nullable()->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('event_items', function (Blueprint $table) {
            if (Schema::hasColumn('event_items', 'details')) {
                $table->dropColumn('details');
            }
        });
    }
};