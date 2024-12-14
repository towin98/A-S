<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThreeFieldsToRecargas extends Migration

{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recargas', function (Blueprint $table) {
            $table->date('fecha_hidrostatica')->after('nuevo_extintor')->default('1900-01-01')->comment('Fecha prueba hidrostatica');
            $table->string('n_interno_cliente',11)->after('fecha_hidrostatica')->default('')->comment('N Interno Cliente');
            $table->string('n_extintor',11)->after('n_interno_cliente')->default('')->comment('N Extintor');
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
            $table->dropColumn(['fecha_hidrostatica','n_interno_cliente','n_extintor']);
        });
    }
}
