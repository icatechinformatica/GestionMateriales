<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemorandumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memorandum', function (Blueprint $table) {
            $table->id();
            $table->string('memorandum', 255)->nullable();
            $table->text('contenido')->nullable();
            $table->unsignedBigInteger("id_requisicion")->nullable();
            $table->boolean('cargado')->nullable();
            $table->timestamps();

            $table->foreign('id_requisicion')
              ->references('id')->on('requisicion')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memorandum');
    }
}
