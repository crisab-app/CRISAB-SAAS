<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Si la columna existe, la destruimos. Si no, la ignoramos.
            if (Schema::hasColumn('events', 'start_time')) {
                $table->dropColumn('start_time');
            }
            
            if (Schema::hasColumn('events', 'end_time')) {
                $table->dropColumn('end_time');
            }
        });
    }

    public function down(): void
    {
        // No necesitamos hacer nada en el down por ahora
    }
};