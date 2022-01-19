<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudSupreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_supre', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('memorandum_solicitud', 150);
            $table->string('memorandum_requisicion', 150);
            $table->date('fecha')->nullable();
            $table->boolean('status')->nullable()->default(false);
            $table->string('nombre_valida')->nullable();
            $table->string('puesto_valida')->nullable();
            $table->string('nombre_recibe')->nullable();
            $table->date('fecha_validacion')->nullable();
            $table->string('memo_solicitud_pago', 200)->nullable();
            $table->string('suficiencia_presupuestal', 200)->nullable();
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
        Schema::dropIfExists('solicitud_supre');
    }
}
