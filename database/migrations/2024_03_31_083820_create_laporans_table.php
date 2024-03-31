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
        Schema::create('laporan', function (Blueprint $table) {
            $table->uuid('laporan_id')->primary();
            $table->foreignUuid('penilaian_id')->references('penilaian_id')->on('penilaian');
            $table->foreignUuid('user_id')->references('user_id')->on('user');
            $table->foreignUuid('departements_id')->references('departements_id')->on('departements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan');
    }
};
