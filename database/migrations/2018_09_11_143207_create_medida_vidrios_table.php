<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedidaVidriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medida_vidrios', function (Blueprint $table) {
            $table->increments('mvdID');
            $table->integer('mvdOrddID');
            $table->integer('mvdOrdID');
            $table->integer('mvdAlto');
            $table->integer('mvdAnchoArriba');
            $table->integer('mvdAnchoAbajo');
            $table->string('mvdTipo');
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
        Schema::dropIfExists('medida_vidrios');
    }
}
