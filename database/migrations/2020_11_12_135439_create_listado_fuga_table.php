<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListadoFugaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listado_prueba', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('recarga_id');
            $table->unsignedInteger('prueba_id');
            #Relacion con la demas tablas
            $table->foreign('recarga_id')->references('id')->on('recargas');
            $table->foreign('prueba_id')->references('id')->on('pruebas');
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
        Schema::dropIfExists('listado_fuga');
    }
}
