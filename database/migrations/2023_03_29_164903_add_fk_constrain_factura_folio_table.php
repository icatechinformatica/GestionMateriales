<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkConstrainFacturaFolioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('factura_folio', function (Blueprint $table) {
            // agregar el foreign key
            $table->foreign('factura_id')->references('id')->on('factura')->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('folio_id')->references('id')->on('folio')->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('factura_folio', function (Blueprint $table) {
            //
        });
    }
}
