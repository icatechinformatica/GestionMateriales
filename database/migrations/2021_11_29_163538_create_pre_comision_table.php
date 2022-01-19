<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreComisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_comision', function (Blueprint $table) {
            $table->id();
            $table->string('rendimiento', 180)->nullable();
            $table->float('costo_combustible', 8, 2)->nullable();
            $table->string('placas_vehiculo', 180)->nullable();
            $table->string('marca_vehiculo', 200)->nullable();
            $table->float('km_totales', 8, 2)->nullable();
            $table->float('peaje', 8, 2)->nullable();
            $table->float('monto_total', 8, 2)->nullable();
            $table->bigInteger('vehiculo_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_comision');
    }
}
