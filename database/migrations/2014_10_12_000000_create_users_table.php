<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('usrNombre');
            $table->string('usrUsuario')->unique();
            $table->string('password');
            $table->integer('usrRolID');
            $table->integer('usrCedula');
            $table->string('usrApellido');
            $table->string('usrTipoDocumento');
            $table->integer('usrActivo');
            $table->string('usrCiudad');
            $table->date('usrFechaCreacion');
            $table->string('usrCelular');
            $table->string('usrDireccion');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
