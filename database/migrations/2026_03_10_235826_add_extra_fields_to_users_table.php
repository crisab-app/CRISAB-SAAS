<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Agregamos las columnas si no existen
            if (!Schema::hasColumn('users', 'paternal_surname')) {
                $table->string('paternal_surname')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'maternal_surname')) {
                $table->string('maternal_surname')->nullable()->after('paternal_surname');
            }
            if (!Schema::hasColumn('users', 'marital_status')) {
                $table->string('marital_status')->nullable()->after('maternal_surname');
            }
            if (!Schema::hasColumn('users', 'profile_photo_path')) {
                $table->string('profile_photo_path')->nullable();
            }
            if (!Schema::hasColumn('users', 'id_front_path')) {
                $table->string('id_front_path')->nullable();
            }
            if (!Schema::hasColumn('users', 'id_back_path')) {
                $table->string('id_back_path')->nullable();
            }
            // Aseguramos que los campos de nacionalidad existan
            if (!Schema::hasColumn('users', 'birthdate')) {
                $table->date('birthdate')->nullable();
            }
            if (!Schema::hasColumn('users', 'nationality')) {
                $table->string('nationality')->nullable();
            }
            if (!Schema::hasColumn('users', 'curp')) {
                $table->string('curp')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'paternal_surname', 'maternal_surname', 'marital_status', 
                'profile_photo_path', 'id_front_path', 'id_back_path',
                'birthdate', 'nationality', 'curp'
            ]);
        });
    }
};