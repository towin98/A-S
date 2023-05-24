<?php

namespace App\Http\Controllers\Utilities;

use App\Models\{Ingreso, NumeroTiquete, Recarga};
use Illuminate\Support\Facades\DB;

trait ConsultaRecarga
{
    public function NumeroEtiqueta($id)
    {
        return NumeroTiquete::select('numero_tiquete')
            ->where('ingreso_id', $id)
            ->where('recarga_id', null)->get()->first();
    }
    public function NumeroSeriaCliente($id)
    {
        $clienteS = Ingreso::select('encargados.numero_serial')
            ->join('encargados', 'ingresos.encargado_id', '=', 'encargados.id')
            ->where('ingresos.id', '=', $id)->get();
        $clienteS = $clienteS[0]['numero_serial'];
        return $clienteS;
    }
    public function InformacionIngreso($id)
    {
        return  DB::table('listado_ingreso')
            ->join('ingresos', 'listado_ingreso.ingreso_id', '=', 'ingresos.id')
            ->join('unidades_medida', 'listado_ingreso.unidad_medida_id', '=', 'unidades_medida.id')
            ->join('subcategorias', 'unidades_medida.sub_categoria_id', '=', 'subcategorias.id')
            ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
            ->join('actividades', 'listado_ingreso.actividad_id', '=', 'actividades.id')
            ->select(
                'listado_ingreso.id',
                'listado_ingreso.ingreso_id',
                'listado_ingreso.numero_extintor',
                'ingresos.fecha_recepcion',
                'unidades_medida.unidad_medida',
                'unidades_medida.cantidad_medida',
                'subcategorias.nombre_subCategoria',
                'categorias.nombre_categoria',
                'actividades.abreviacion_actividad',
                'actividades.nombre_actividad'
            )->where('ingreso_id', $id)->get();
    }
    public function listadoRecarga($id)
    {
        return Recarga::select('recargas.nro_tiquete_anterior', 'recargas.nro_tiquete_nuevo','nro_extintor',
                                'actividades.nombre_actividad', 'unidades_medida.cantidad_medida','unidades_medida.unidad_medida')
        ->where('ingreso_recarga_id', $id)
        ->join('actividades', 'recargas.activida_recarga_id', '=', 'actividades.id')
        ->join('unidades_medida', 'recargas.capacidad_id', '=', 'unidades_medida.id')
        ->get();

        /* return Recarga::where('ingreso_recarga_id', $id)
            ->with('RecargaUsuario', 'UnidadMedida', 'RecargaActividad', 'RecargaIngreso', 'RecargaFuga')->get(); */
    }
}
