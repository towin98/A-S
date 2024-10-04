<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoToRecargas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recargas', function (Blueprint $table) {
            $table->integer('estado')->after('ingreso_actividad')->default(1)->comment('Estado de la orden');
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
            $table->dropColumn('estado');
        });
    }
}
