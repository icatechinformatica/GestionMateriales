<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuntoAPuntoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punto_a_punto', function (Blueprint $table) {
            $table->id();
            $table->text('_de')->nullable();
            $table->text('_a')->nullable();
            $table->float('kms', 8, 2)->nullable();
            $table->float('peaje', 8, 2)->nullable();
            $table->bigInteger('pre_comision_id')->nullable()->unsigned();
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
        Schema::dropIfExists('punto_a_punto');
    }
}
