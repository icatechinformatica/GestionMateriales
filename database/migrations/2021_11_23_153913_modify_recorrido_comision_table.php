<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyRecorridoComisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recorrido_comision', function (Blueprint $table) {
            //
            $table->bigInteger('solicitud_id')->nullable()->unsigned();
            $table->foreign('solicitud_id')
                ->references('id')
                ->on('solicitud')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recorrido_comision', function (Blueprint $table) {
            //
        });
    }
}
