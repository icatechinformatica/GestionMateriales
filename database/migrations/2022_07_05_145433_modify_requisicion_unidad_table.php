<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyRequisicionUnidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisicion_unidad', function (Blueprint $table) {
            //
            $table->unsignedBigInteger("id_partida_presupuestal")->nullable();
            $table->foreign('id_partida_presupuestal')
              ->references('id')->on('partida_presupuestal')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisicion_unidad', function (Blueprint $table) {
            //
        });
    }
}
