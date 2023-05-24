<?php

namespace App\Http\Controllers\Utilities;

use App\Models\{listadoPrueba, listadoRecarga};

trait CambioPartesListado
{
    public function saveListChangeParts($id, $listadoPartes)
    {
        foreach ($listadoPartes as $key => $value) {
            $nuevoListado =  new listadoRecarga();
            $nuevoListado->recarga_id = $id;
            $nuevoListado->cambio_parte_id = $value;
            $nuevoListado->save();
        }
    }
    public function ListadoPartes($id)
    {
        return listadoRecarga::select('cambio_parte_extintor.nombre_parte_cambio')
            ->where('recarga_id', $id)
            ->join('cambio_parte_extintor', 'listado_recarga.cambio_parte_id', '=', 'cambio_parte_extintor.id')->get();
    }
    public function ListadoPruebas($id)
    {
        return listadoPrueba::select('pruebas.nombre_prueba')
            ->join('pruebas', 'listado_prueba.prueba_id', '=', 'pruebas.id')
            ->where('listado_prueba.recarga_id', $id)
            ->get();
    }
}
