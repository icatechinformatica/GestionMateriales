<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddForeignKeyDirectorioSolicitudSupre extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('directorio_solicitud_supre', function (Blueprint $table) {
            //
            $table->foreign('solicitud_supre_id')
                ->references('id')
                ->on('solicitud_supre')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('directorio_id')
                ->references('id')
                ->on('directorio')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('directorio_solicitud_supre', function (Blueprint $table) {
            //
        });
    }
}
