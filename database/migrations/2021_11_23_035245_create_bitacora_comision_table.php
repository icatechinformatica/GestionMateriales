<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBitacoraComisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora_comision', function (Blueprint $table) {
            $table->id();
            $table->string('factura_comision', 250)->nullable();
            $table->float('litros_comision', 8, 2)->nullable();
            $table->decimal('precio_unitario_comision', 8, 2)->nullable();
            $table->decimal('importe_comision', 8, 2)->nullable();
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
        Schema::dropIfExists('bitacora_comision');
    }
}
