<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisicionMaterialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisicion_materiales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_requisicion")->nullable();
            $table->unsignedBigInteger("id_requisicion_unidad")->nullable();
            $table->timestamps();

            $table->foreign('id_requisicion')
              ->references('id')->on('requisicion')->onDelete('set null');

            $table->foreign('id_requisicion_unidad')
            ->references('id')->on('requisicion_unidad')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisicion_materiales');
    }
}
