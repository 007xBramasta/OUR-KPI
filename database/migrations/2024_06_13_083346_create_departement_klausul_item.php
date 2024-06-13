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
        Schema::create('departement_klausul_item', function (Blueprint $table) {
            $table
                ->foreignUuid('departement_id')
                ->references('departements_id')
                ->on('departements')
                ->cascadeOnDelete();
            $table
                ->foreignUuid('klausul_item_id')
                ->references('id')
                ->on('klausul_items')
                ->cascadeOnDelete(); 
            $table->unique(['departement_id', 'klausul_item_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departement_klausul_item');
    }
};
