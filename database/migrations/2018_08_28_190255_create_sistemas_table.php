<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSistemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistemas', function (Blueprint $table) {
          $table->increments('stmID');
          $table->string('stmTipo');
          $table->integer('stmCodigoWO');
          $table->string('stmDescripcion');
          $table->integer('stmPrecioVenta');
          $table->integer('stmPrecioCompra');
          $table->integer('stmActivo');
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
        Schema::dropIfExists('sistemas');
    }
}
