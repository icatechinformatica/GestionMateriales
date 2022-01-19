<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyRecorridoComisionTemporalTable extends Migration
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
            $table->bigInteger('temporal_id')->nullable()->unsigned();
            $table->foreign('temporal_id')
                ->references('id')
                ->on('temporal')->onDelete('cascade')->onUpdate('cascade');
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
