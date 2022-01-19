<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAddFkPreComisionIdToPreComisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('punto_a_punto', function (Blueprint $table) {
            //
            $table->foreign('pre_comision_id')
                ->references('id')
                ->on('pre_comision')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('punto_a_punto', function (Blueprint $table) {
            //
        });
    }
}
