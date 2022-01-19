<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRowsCatalogoVehiculoTable extends Migration
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
            $table->string('rendimiento_ciudad', 20)->nullable();
            $table->string('rendimiento_carretera', 20)->nullable();
            $table->string('rendimiento_mixto', 20)->nullable();
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
