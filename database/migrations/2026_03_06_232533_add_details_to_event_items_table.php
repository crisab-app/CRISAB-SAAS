<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_items', function (Blueprint $table) {
            // Usamos 'text' para que puedan pegar pasajes largos o letras completas
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