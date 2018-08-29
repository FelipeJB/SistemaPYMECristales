<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSistemaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema_detalles', function (Blueprint $table) {
            $table->increments('stmdID');
            $table->integer('stmdSistemaID');
            $table->string('stmdCodigoWO');
            $table->string('stmdDescripcion');
            $table->integer('stmdCantidad');
            $table->integer('stmdActivo');
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
        Schema::dropIfExists('sistema_detalles');
    }
}
