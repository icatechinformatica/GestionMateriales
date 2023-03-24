<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProducto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->string('clave')->nullable();
            $table->string('nombre')->nullable();
            $table->text('descripcion')->nullable();
            $table->integer('existencia')->nullable();
            $table->integer('minimo')->nullable();
            $table->string('unidad_medida', 100)->nullable();
            $table->decimal('precio', 10, 2)->nullable();
            $table->unsignedBigInteger("id_partida")->nullable();
            $table->timestamps();

            $table->foreign('id_partida')
              ->references('id')->on('partida')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
