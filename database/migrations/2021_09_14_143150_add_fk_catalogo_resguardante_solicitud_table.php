<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkCatalogoResguardanteSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitud', function (Blueprint $table) {
            //
            $table->foreign('catalogo_vehiculo_id')
                ->references('id')
                ->on('catalogo_vehiculo')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('directorio_id')
                ->references('id')
                ->on('directorio')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitud', function (Blueprint $table) {
            //
        });
    }
}
