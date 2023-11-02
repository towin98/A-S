<?php

namespace App\Http\Controllers\Utilities;

use App\Models\listadoPrueba;

trait FugaListado
{
    public function saveLeakagelist($id, $listadoFuga)
    {
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
