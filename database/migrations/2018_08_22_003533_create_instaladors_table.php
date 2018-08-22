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
            $table->increments('insid');
            $table->string('usrNombre');
            $table->string('usrApellido');
            $table->string('usrTipoDocumento');
            $table->bigInteger('usrCedula');
            $table->string('usrCiudad');
            $table->date('usrFechaCreacion');
            $table->string('usrCelular');
            $table->string('usrDireccion');
            $table->integer('usrActivo');
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
