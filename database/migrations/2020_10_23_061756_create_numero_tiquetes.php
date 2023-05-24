<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumeroTiquetes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numero_tiquetes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero_tiquete');
            $table->unsignedInteger('ingreso_id')->nullable();
            $table->unsignedInteger('recarga_id')->nullable();
            $table->boolean('estado')->default(1);
            $table->timestamps();

            $table->foreign('ingreso_id')->references('id')->on('ingresos');
            $table->foreign('recarga_id')->references('id')->on('recargas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('numero_tiquetes');
    }
}
