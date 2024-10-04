<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNuevoExtintorToRecargas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recargas', function (Blueprint $table) {
            $table->string('nuevo_extintor',2)->after('ingreso_actividad')->nullable()->comment('Cambio por extintor nuevo, no poderder etiqueta');
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
            $table->dropColumn('nuevo_extintor');
        });
    }
}
