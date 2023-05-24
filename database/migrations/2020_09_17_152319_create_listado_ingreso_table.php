<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListadoIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listado_ingreso', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ingreso_id');
            $table->unsignedInteger('unidad_medida_id');
            $table->unsignedInteger('actividad_id');
            $table->integer('numero_extintor');
            $table->boolean('estado')->default(true);
            $table->timestamps();

            #LLaves foreneas
            $table->foreign('ingreso_id')->references('id')->on('ingresos');
            $table->foreign('unidad_medida_id')->references('id')->on('unidades_medida');
            $table->foreign('actividad_id')->references('id')->on('actividades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listado_ingreso');
    }
}
