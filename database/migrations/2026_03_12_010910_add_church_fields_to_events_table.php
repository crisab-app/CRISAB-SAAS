<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'preaching_topic')) {
                $table->string('preaching_topic')->nullable()->after('description'); // Tema del sermón
            }
            if (!Schema::hasColumn('events', 'liturgy_details')) {
                $table->text('liturgy_details')->nullable()->after('preaching_topic'); // Cantos, lecturas, etc.
            }
            if (!Schema::hasColumn('events', 'attendance_count')) {
                $table->integer('attendance_count')->default(0)->after('liturgy_details'); // Asistencia
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['preaching_topic', 'liturgy_details', 'attendance_count']);
        });
    }
};