<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoVehiculoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->string('color', 150);
            $table->string('numero_motor', 150);
            $table->string('marca', 150);
            $table->string('modelo', 150);
            $table->string('tipo', 250);
            $table->string('placas', 50);
            $table->string('numero_serie', 50)->unique();
            $table->bigInteger('resguardante_id')->unsigned();
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
        Schema::dropIfExists('catalogo_vehiculo');
    }
}
