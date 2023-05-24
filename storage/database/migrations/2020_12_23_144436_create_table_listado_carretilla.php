<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableListadoCarretilla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listado_carretilla', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_registro_hocol')->comment('relacion con el registro de hocol');
            $table->unsignedInteger('id_extintores_carretilla')->comment('relacion con las partes de extintores carretilla');;
            $table->timestamps();

            $table->foreign('id_registro_hocol')->references('id')->on('registro_hocol');
            $table->foreign('id_extintores_carretilla')->references('id')->on('hocol_extintores_carretilla');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_listado_carretilla');
    }
}
