<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Agregamos el switch de bautizado y la fecha
        $table->boolean('is_baptized')->default(false)->after('birthdate'); // Ajusta 'birthdate' al campo que tengas
        $table->date('baptism_date')->nullable()->after('is_baptized');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['is_baptized', 'baptism_date']);
    });
}
};
