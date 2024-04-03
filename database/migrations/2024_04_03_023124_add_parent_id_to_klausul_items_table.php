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
        Schema::table('klausul_items', function (Blueprint $table) {
            $table->foreignUuid('parent_id')->after('id')->nullable()->references('id')->on('klausul_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('klausul_items', function (Blueprint $table) {
            $table->dropForeign('klausul_items_parent_id_foreign');
            $table->dropColumn('parent_id');
        });
    }
};
