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
    Schema::table('events', function (Blueprint $table) {
        if (!Schema::hasColumn('events', 'sermon_notes')) {
            $table->longText('sermon_notes')->nullable()->after('preaching_topic');
        }
    });
}

public function down(): void
{
    Schema::table('events', function (Blueprint $table) {
        $table->dropColumn('sermon_notes');
    });
}
};
