<?php

namespace App\Http\Controllers\Utilities;

use App\Models\listadoPrueba;

trait FugaListado
{
    /**
     * Método que guardar listado de pruebas de pruebas que se le hicieron al extintor
     *
     * @param integer $id de la recarga
     * @param array $listadoFuga listado de pruebas de pruebas realizadas
     * @return void
     */
    public function saveLeakagelist(int $id, array $listadoFuga)
    {
        //Eliminado listado de pruebas del extintor
        listadoPrueba::where("recarga_id", $id)->delete();

        if (isset($listadoFuga)) {
            foreach ($listadoFuga as $key => $value) {
                $nuevoListadoFuga =  new listadoPrueba();
                $nuevoListadoFuga->recarga_id = $id;
                $nuevoListadoFuga->prueba_id = $value;
                $nuevoListadoFuga->save();
            }
        }
    }
}
