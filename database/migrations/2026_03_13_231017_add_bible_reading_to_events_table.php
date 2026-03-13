<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cambia 'events' por el nombre real de tu tabla si es diferente
        Schema::table('events', function (Blueprint $table) {
            $table->string('bible_reading')->nullable()->after('preaching_topic');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('bible_reading');
        });
    }
};