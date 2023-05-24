<?php

namespace App\Http\Controllers\Utilities;

use App\Models\Hocol;
use App\Models\{ListadoCarretilla, ListadoPortatil};

trait RegistroHocol
{
    public function nuevoRegistro($request)
    {
        $nuevoRegistroHocol = new Hocol();
        $nuevoRegistroHocol->area = $request->area;
        $nuevoRegistroHocol->id_colaborador = $request->id_inspeccionado;
        $nuevoRegistroHocol->NmExtintor = $request->NoExtintor;
        $nuevoRegistroHocol->tipo = $request->tipo;
        $nuevoRegistroHocol->id_capacidad = $request->capacidadProducto;
        $nuevoRegistroHocol->ubicacion = $request->ubicacion;
        $nuevoRegistroHocol->ultima_recarga = $request->URecarga;
        $nuevoRegistroHocol->proxima_recarga = $request->PRecarga;
        $nuevoRegistroHocol->hidrostatica = $request->hidrostatica;
        $nuevoRegistroHocol->observacion = $request->observacion;
        $nuevoRegistroHocol->fecha_inspeccion = $request->inspeccion;
        $nuevoRegistroHocol->save();
        return $nuevoRegistroHocol->id;
    }
    public function listadoPortatil($id, $listadoPartePortatil)
    {

        if($listadoPartePortatil){
            foreach ($listadoPartePortatil as $key => $value){
                $ArrayPartes = (explode('-', $value));
                $nuevoListadoPortatil =  new ListadoPortatil();
                $nuevoListadoPortatil->id_registro_hocol = $id;
                $nuevoListadoPortatil->id_extintores_portatil =trim($ArrayPartes[0]);
                $nuevoListadoPortatil->estado =trim($ArrayPartes[1]);
                $nuevoListadoPortatil->save();
            }
        }
        return 'Registro portatil con exito';
    }
    public function listadoCarretilla($id, $listadoParteCarretilla)
    {
        if ($listadoParteCarretilla) {
            foreach ($listadoParteCarretilla as $key => $value) {
                $ArrayPartes = (explode('-', $value));
                $nuevoListadoCarretilla =  new ListadoCarretilla();
                $nuevoListadoCarretilla->id_registro_hocol = $id;
                $nuevoListadoCarretilla->id_extintores_carretilla = trim($ArrayPartes[0]);
                $nuevoListadoCarretilla->estado =trim($ArrayPartes[1]);
                $nuevoListadoCarretilla->save();
            }
        }
        return 'Registro carretilla con exito';
    }
}
