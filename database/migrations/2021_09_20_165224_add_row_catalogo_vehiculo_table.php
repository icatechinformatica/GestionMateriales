<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRowCatalogoVehiculoTable extends Migration
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
            $table->string('linea', 250)->nullable();
            $table->decimal('importe_combustible', 8,2)->nullable();
            $table->bigInteger('area_adscripcion_id')->unsigned();

            $table->foreign('area_adscripcion_id')
                ->references('id')
                ->on('area_adscripcion')->onDelete('cascade')->onUpdate('cascade');
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
