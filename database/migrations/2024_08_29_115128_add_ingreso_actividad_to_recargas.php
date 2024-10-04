<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIngresoActividadToRecargas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recargas', function (Blueprint $table) {
            $table->boolean('ingreso_actividad')->after('observacion')->comment('Ingreso actividad del extintor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recargas', function (Blueprint $table) {
            $table->dropColumn('ingreso_actividad');
        });
    }
}
