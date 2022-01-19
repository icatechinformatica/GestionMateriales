<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRowsTemporalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temporal', function (Blueprint $table) {
            //
            $table->integer('periodo_actual')->nullable();
            $table->year('anio_actual')->nullable();
            $table->float('litros_totales', 9, 2)->nullable();
            $table->decimal('importe_total', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temporal', function (Blueprint $table) {
            //
        });
    }
}
