<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectorioSolicitudSupre extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directorio_solicitud_supre', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('directorio_id')->unsigned();

            $table->bigInteger('solicitud_supre_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directorio_solicitud_supre');
    }
}
