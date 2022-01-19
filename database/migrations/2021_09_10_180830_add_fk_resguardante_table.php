<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkResguardanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resguardante', function (Blueprint $table) {
            //
            $table->foreign('area_adscripcion_id')
                ->references('id')
                ->on('area_adscripcion')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resguardante', function (Blueprint $table) {
            //
        });
    }
}
