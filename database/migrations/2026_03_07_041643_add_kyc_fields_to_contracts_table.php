<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('unique_church_id')->unique()->nullable();
            $table->string('denomination')->nullable();
            $table->text('address')->nullable();
            $table->string('maps_coordinates')->nullable();
            $table->string('initiator_name')->nullable();
            // Los campos que terminan en _path guardarán la ubicación del archivo en tu servidor
            $table->string('registration_document_path')->nullable();
            $table->string('exterior_photo_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn([
                'unique_church_id', 'denomination', 'address', 
                'maps_coordinates', 'initiator_name', 
                'registration_document_path', 'exterior_photo_path'
            ]);
        });
    }
};