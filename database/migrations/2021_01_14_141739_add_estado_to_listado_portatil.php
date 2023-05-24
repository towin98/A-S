<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoToListadoPortatil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listado_portatil', function (Blueprint $table) {
            $table->string('estado')
                ->after('id_extintores_portatil')
                ->comment('Condiccion en que se encuentra cada parte del extintor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listado_portatil', function (Blueprint $table) {
            //
        });
    }
}
