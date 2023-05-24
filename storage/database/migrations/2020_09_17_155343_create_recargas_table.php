<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recargas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nro_tiquete_anterior')->nullable();
            $table->integer('nro_tiquete_nuevo');
            $table->integer('nro_extintor');
            $table->unsignedInteger('capacidad_id');
            $table->string('agente')->nullable();
            $table->unsignedInteger('usuario_recarga_id');
            $table->unsignedInteger('ingreso_recarga_id');
            $table->unsignedInteger('activida_recarga_id');
            $table->unsignedInteger('fuga_id')->nullable();
            $table->string('observacion')->nullable();
            $table->timestamps();

            #LLaves foreneas 
            $table->foreign('capacidad_id')->references('id')->on('unidades_medida');
            $table->foreign('usuario_recarga_id')->references('id')->on('users');
            $table->foreign('ingreso_recarga_id')->references('id')->on('ingresos');
            $table->foreign('activida_recarga_id')->references('id')->on('actividades');
            $table->foreign('fuga_id')->references('id')->on('fugas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recargas');
    }
}
