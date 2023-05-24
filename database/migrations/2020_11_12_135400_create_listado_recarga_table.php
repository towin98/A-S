<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListadoRecargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listado_recarga', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recarga_id');
            $table->unsignedInteger('cambio_parte_id');
            $table->timestamps();

            #Relacion con la demas tablas
            $table->foreign('recarga_id')->references('id')->on('recargas');
            $table->foreign('cambio_parte_id')->references('id')->on('cambio_parte_extintor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listado_recarga');
    }
}
