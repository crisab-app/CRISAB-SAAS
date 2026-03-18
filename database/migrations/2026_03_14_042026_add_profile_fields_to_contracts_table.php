<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('logo_path')->nullable();
            $table->string('cover_photo_path')->nullable();
            $table->longText('history')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();            
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn([
                'logo_path', 'cover_photo_path', 'history', 
                'contact_email', 'contact_phone', // 'address', <--- QUÍTALA DE AQUÍ TAMBIÉN
                'facebook_url', 'youtube_url'
            ]);
        });
    }
};