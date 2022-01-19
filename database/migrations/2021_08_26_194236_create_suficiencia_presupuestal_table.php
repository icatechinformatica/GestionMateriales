<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuficienciaPresupuestalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suficiencia_presupuestal', function (Blueprint $table) {
            $table->id();
            $table->string('proveedor', 250)->nullable();
            $table->string('area', 250)->nullable();
            $table->text('proyecto_descripcion')->nullable();
            $table->string('partida_concepto', 250)->nullable();
            $table->decimal('importe', 8, 2)->nullable();
            $table->unsignedBigInteger('solicitud_supre_id')->nullable();
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
        Schema::dropIfExists('suficiencia_presupuestal');
    }
}
