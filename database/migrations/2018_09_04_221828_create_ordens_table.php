<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordens', function (Blueprint $table) {
            $table->increments('ordID');
            $table->integer('ordNumeroPedido')->nullable();
            $table->date('ordFecha');
            $table->integer('ordPuntoVentaID');
            $table->integer('ordVendedorID');
            $table->integer('ordClienteID');
            $table->integer('ordFormaPagoID');
            $table->integer('ordTotal');
            $table->integer('ordTotalCompra');
            $table->integer('ordAbono');
            $table->integer('ordSaldo');
            $table->integer('ordEstadoInstalacionID');
            $table->string('ordRazonNegativa')->nullable();
            $table->dateTime('ordFechaInstalacion')->nullable();
            $table->integer('ordInstaladorID')->nullable();
            $table->string('ordObservaciones')->nullable();
            $table->integer('ordMigrado');
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
        Schema::dropIfExists('ordens');
    }
}
