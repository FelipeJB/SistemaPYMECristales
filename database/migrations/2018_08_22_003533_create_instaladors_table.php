<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstaladorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instaladors', function (Blueprint $table) {
            $table->increments('insID');
            $table->string('insNombre');
            $table->string('insApellido');
            $table->string('insTipoDocumento');
            $table->bigInteger('insCedula');
            $table->string('insCiudad');
            $table->date('insFechaCreacion');
            $table->string('insCelular');
            $table->string('insDireccion');
            $table->integer('insActivo');
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
        Schema::dropIfExists('instaladors');
    }
}
