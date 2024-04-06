<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klausuls_laporans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('klausul_id')->references('id')->on('klausuls');
            $table->foreignUuid('laporan_id')->references('laporan_id')->on('laporan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('klausuls_laporans');
    }
};
