<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_recepcion');
            $table->date('fecha_entrega')->nullable();
            $table->unsignedInteger('encargado_id')->nullable();
            $table->unsignedInteger('usuario_id');
            $table->integer('numero_referencia')->nullable();
            $table->integer('numero_total_extintor')->nullable();
            $table->string('estado')->default('recibido');
            $table->timestamps();

            #LLaves foreneas 
            $table->foreign('encargado_id')->references('id')->on('encargados');
            $table->foreign('usuario_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingresos');
    }
}
