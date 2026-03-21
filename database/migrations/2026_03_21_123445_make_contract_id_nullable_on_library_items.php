<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('library_items', function (Blueprint $table) {
            // Permitimos que contract_id sea nulo (Global)
            $table->unsignedBigInteger('contract_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('library_items', function (Blueprint $table) {
            $table->unsignedBigInteger('contract_id')->nullable(false)->change();
        });
    }
};