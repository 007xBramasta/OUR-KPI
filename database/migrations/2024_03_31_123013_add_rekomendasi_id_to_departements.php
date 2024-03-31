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
        Schema::table('departements', function (Blueprint $table) {
            $table->foreignUuid('rekomendasi_id')->nullable(true)->references('rekomendasi_id')->on('rekomendasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departements', function (Blueprint $table) {
            $table->dropForeign('departements_rekomendasi_id_foreign');
            $table->dropColumn('rekomendasi_id');
        });
    }
};
