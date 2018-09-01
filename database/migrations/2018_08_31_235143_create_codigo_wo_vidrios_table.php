<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodigoWoVidriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigo_wo_vidrios', function (Blueprint $table) {
            $table->increments('cdgID');
            $table->integer('cdgMilimID');
            $table->integer('cdgColorID');
            $table->string('cdgWO');
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
        Schema::dropIfExists('codigo_wo_vidrios');
    }
}
