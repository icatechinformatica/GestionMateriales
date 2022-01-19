<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkSeguimientoSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seguimiento_solicitud', function (Blueprint $table) {
            //
            $table->foreign('solicitud_id')
                ->references('id')
                ->on('solicitud')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('status_seguimiento_id')
                ->references('id')
                ->on('seguimiento_status')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seguimiento_solicitud', function (Blueprint $table) {
            //
        });
    }
}
