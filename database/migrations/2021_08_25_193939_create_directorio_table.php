<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectorioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directorio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200)->nullable();
            $table->string('apellido_paterno', 200)->nullable();
            $table->string('apellido_materno', 200)->nullable();
            $table->string('puesto', 150)->nullable();
            $table->unsignedBigInteger('area_adscripcion_id');
            $table->boolean('activo')->nullable();
            $table->boolean('qr_generado')->nullable();
            $table->char('numero_enlace', 9)->nullable();
            $table->string('categoria', 250)->nullable();
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
        Schema::dropIfExists('directorio');
    }
}
