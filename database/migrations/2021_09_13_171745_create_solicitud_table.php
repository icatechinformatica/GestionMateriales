<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('catalogo_vehiculo_id')->unsigned();
            $table->bigInteger('directorio_id')->unsigned();
            $table->string('memorandum_comision', 150);
            $table->date('fecha')->nullable();
            $table->string('periodo', 250);
            $table->integer('km_inicial')->nullable();
            $table->string('numero_factura_compra', 250)->nullable();
            $table->string('conductor', 250)->nullable();
            $table->string('nombre_elabora', 250)->nullable();
            $table->string('puesto_elabora', 250)->nullable();
            $table->string('titular_departamento', 250)->nullable();
            $table->integer('km_final_antes_cargar_combustible')->nullable();
            $table->integer('km_inicial_cargar_combustible')->nullable();
            $table->integer('total_km_recorridos')->nullable();
            $table->char('numero_economico', 100)->nullable();
            $table->boolean('status_proceso')->default(false);
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
        Schema::dropIfExists('solicitud');
    }
}
