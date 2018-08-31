<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrecioVidriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precio_vidrios', function (Blueprint $table) {
          $table->increments('pvdID');
          $table->integer('pvdMilimID');
          $table->integer('pvdSistemaID');
          $table->integer('pvdPrecioVenta');
          $table->integer('pvdPrecioCompra');
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
        Schema::dropIfExists('precio_vidrios');
    }
}
