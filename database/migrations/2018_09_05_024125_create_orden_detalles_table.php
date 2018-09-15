<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_detalles', function (Blueprint $table) {
            $table->increments('orddID');
            $table->integer('orddOrdenID');
            $table->integer('orddItem');
            $table->integer('orddDescuento')->nullable();
            $table->integer('orddTotal');
            $table->integer('orddTotalCompra');
            $table->integer('orddCantVidrio');
            $table->integer('orddCantToalleros');
            $table->integer('orddSistemaID');
            $table->integer('orddMilimID');
            $table->integer('orddColorID');
            $table->integer('orddDisenoID');
            $table->integer('orddEstadoMedidasID')->nullable();
            $table->integer('orddRazonNegativa')->nullable();
            $table->dateTime('orddFechaMedidas')->nullable();
            $table->integer('orddAuxiliarID')->nullable();
            $table->string('orddObservaciones')->nullable();
            $table->integer('orddAlto')->nullable();
            $table->integer('orddAncho')->nullable();
            $table->integer('orddRelacion')->nullable();
            $table->integer('orddValorAdicional')->nullable();
            $table->string('orddDescripcionAdicional')->nullable();
            $table->string('orddLadoPuerta')->nullable();
            $table->string('orddObservacionesVidrio')->nullable();
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
        Schema::dropIfExists('orden_detalles');
    }
}
