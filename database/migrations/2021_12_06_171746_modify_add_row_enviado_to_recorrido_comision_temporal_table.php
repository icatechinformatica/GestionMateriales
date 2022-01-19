<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAddRowEnviadoToRecorridoComisionTemporalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recorrido_comision_temporal', function (Blueprint $table) {
            //
            $table->boolean('enviado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recorrido_comision_temporal', function (Blueprint $table) {
            //
        });
    }
}
