<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyRequisicionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisicion', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('id_estado')->nullable();

            $table->foreign('id_estado')->references('id')->on('seguimiento_status')->onDelete('set null');
            // $table->foreign('id_area')
            //   ->references('id')->on('area_adscripcion')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisicion', function (Blueprint $table) {
            //
        });
    }
}
