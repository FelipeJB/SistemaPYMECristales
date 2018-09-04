<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('cltID');
            $table->string('cltNombre');
            $table->string('cltApellido');
            $table->string('cltEmail');
            $table->string('cltTipoDocumento');
            $table->bigInteger('cltCedula');
            $table->string('cltCiudad');
            $table->date('cltFechaCreacion');
            $table->string('cltCelular1');
            $table->string('cltCelular2');
            $table->string('cltDireccion');
            $table->string('cltTipoCliente');
            $table->integer('cltTarifaICA');
            $table->integer('cltUsuarioCreador');
            $table->integer('cltMigrado');
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
        Schema::dropIfExists('clientes');
    }
}
