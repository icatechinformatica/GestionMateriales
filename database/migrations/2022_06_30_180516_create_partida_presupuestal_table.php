<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidaPresupuestalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partida_presupuestal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_requisicion')->nullable();
            $table->unsignedBigInteger("id_partida")->nullable();
            $table->timestamps();

            $table->foreign('id_partida')
              ->references('id')->on('partida')->onDelete('set null');

            $table->foreign('id_requisicion')
              ->references('id')->on('requisicion')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partida_presupuestal');
    }
}
