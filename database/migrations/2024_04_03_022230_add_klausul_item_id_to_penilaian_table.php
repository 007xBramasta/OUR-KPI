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
        Schema::table('penilaians', function (Blueprint $table) {
            $table->foreignUuid('klausul_item_id')->after('id')->references('id')->on('klausul_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penilaians', function (Blueprint $table) {
            $table->dropForeign('penilaians_klausul_item_id_foreign');
            $table->dropColumn('klausul_item_id');
        });
    }
};
