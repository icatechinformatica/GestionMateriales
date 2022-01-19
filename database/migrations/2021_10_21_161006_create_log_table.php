<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log', function (Blueprint $table) {
            $table->id();
            $table->string('operacion', 250)->nullable();
            $table->string('usuario', 250)->nullable();
            $table->string('ip_request', 250)->nullable();
            $table->string('mac_request', 250)->nullable();
            $table->string('sistem_path', 250)->nullable();
            $table->date('fecha_ejecucion')->nullable();
            $table->time('hoarario_ejecucion', 0)->nullable();
            $table->bigInteger('tipo_interaccion')->unsigned()->nullable();
            $table->string('tipo_peticion', 250)->nullable();
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
        Schema::dropIfExists('log');
    }
}
