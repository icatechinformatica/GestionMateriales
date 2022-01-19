<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRowsToCatalogoVehiculoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('catalogo_vehiculo', function (Blueprint $table) {
            //
            $table->string('rendimiento_carga', 20)->nullable();
            $table->integer('km_inicial')->nullable();
            $table->integer('km_final')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catalogo_vehiculo', function (Blueprint $table) {
            //
        });
    }
}
