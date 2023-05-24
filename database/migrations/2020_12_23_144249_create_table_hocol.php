<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHocol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_hocol', function (Blueprint $table) {
            $table->increments('id');
            $table->string('area')->comment('sede donde se encuentra ubicado')->nullable();
            $table->unsignedInteger('id_colaborador')->comment('Persona que realizo el ingreso')->nullable();
            $table->string('NmExtintor')->comment('Numero interno del extintor')->nullable();
            $table->string('tipo')->comment('Tipo de extintor')->nullable();
            $table->unsignedInteger('id_capacidad')->comment('Capacidad del producto')->nullable();
            $table->string('ubicacion')->comment('lugar exacto donde se encuentra ubicado')->nullable();
            $table->string('ultima_recarga')->comment('fecha de ultima recarga')->nullable();
            $table->string('proxima_recarga')->comment('fecha de proxima recarga')->nullable();
            $table->string('hidrostatica')->comment('fecha de prueba hidrostatica')->nullable();
            $table->string('observacion')->comment('observacion realizada')->nullable();
            $table->string('fecha_inspeccion')->comment('fecha de inspeccion')->nullable();
            $table->timestamps();

            #LLaves foreneas 
            $table->foreign('id_colaborador')->references('id')->on('users');
            $table->foreign('id_capacidad')->references('id')->on('unidades_medida');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registro_hocol');
    }
}
