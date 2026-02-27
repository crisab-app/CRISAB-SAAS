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
        Schema::table('groups', function (Blueprint $table) {
            // Creamos un código alfanumérico único para cada grupo
            $table->uuid('uuid')->nullable()->unique();
        });
    }

    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
