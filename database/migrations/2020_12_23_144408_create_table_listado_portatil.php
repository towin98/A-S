<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableListadoPortatil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listado_portatil', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_registro_hocol')->comment('relacion con el registro de hocol');
            $table->unsignedInteger('id_extintores_portatil')->comment('relacion con las partes de extintores portatiles');;
            $table->timestamps();

            #LLaves foreneas 
            $table->foreign('id_registro_hocol')->references('id')->on('registro_hocol');
            $table->foreign('id_extintores_portatil')->references('id')->on('hocol_extintor_portatil');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_listado_portatil');
    }
}
