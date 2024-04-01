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
        Schema::create('penilaian', function (Blueprint $table) {
            $table->uuid('penilaian_id')->primary();
            $table->string('penilaian_indikator');
            $table->integer('penilaian_target');
            $table->string('penilaian_aktual');
            $table->string('penilaian_keterangan');
            $table->string('rekomendasi')->nullable();
            $table->boolean('disetujui')->default(false);
            $table->foreignUuid('klausul_id')->references('klausul_id')->on('klausul');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaian');
    }
};
