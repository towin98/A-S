<?php

namespace App\Http\Controllers\Utilities;

use App\Models\{Ingreso, NumeroTiquete, Recarga};
use Illuminate\Support\Facades\DB;

trait ConsultaRecarga
{
    /**
     * Método trae informacion del cliente por el id de la orden de ingreso
     *
     * @param [type] $id Orden de ingreso
     * @return JsonResponse
     */
    public function DatosClienteOrden($id)
    {
        $cliente = Ingreso::select([
                'encargados.id',
                'encargados.numero_serial',
                'encargados.nombre_encargado',
                'ingresos.id as idOrden'
            ])
            ->join('encargados', 'ingresos.encargado_id', '=', 'encargados.id')
            ->where('ingresos.id', '=', $id)
            ->first();

        return $cliente;
    }

    /**
     * Método trae la información del ingreso por el id de la orden de ingreso
     *
     * @param integer $id Orden de ingreso
     * @return JsonResponse
     */
    public function InformacionIngreso($id)
    {
        return  DB::table('listado_ingreso')
            ->join('ingresos', 'listado_ingreso.ingreso_id', '=', 'ingresos.id')
            ->join('unidades_medida', 'listado_ingreso.unidad_medida_id', '=', 'unidades_medida.id')
            ->join('subcategorias', 'unidades_medida.sub_categoria_id', '=', 'subcategorias.id')
            ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
            ->join('actividades', 'listado_ingreso.actividad_id', '=', 'actividades.id')
            ->select(

                'listado_ingreso.unidad_medida_id',
                'listado_ingreso.actividad_id',

                DB::raw('MAX(listado_ingreso.id) as id'),
                DB::raw('MAX(listado_ingreso.ingreso_id) as ingreso_id'),
                DB::raw('SUM(listado_ingreso.numero_extintor) as numero_extintor'),
                DB::raw('MAX(ingresos.fecha_recepcion) as fecha_recepcion'),
                DB::raw('MAX(unidades_medida.unidad_medida) as unidad_medida'),
                DB::raw('MAX(unidades_medida.cantidad_medida) as cantidad_medida'),
                DB::raw('MAX(subcategorias.nombre_subCategoria) as nombre_subCategoria'),
                DB::raw('MAX(categorias.nombre_categoria) as nombre_categoria'),
                DB::raw('MAX(actividades.abreviacion_actividad) as abreviacion_actividad'),
                DB::raw('MAX(actividades.nombre_actividad) as nombre_actividad')
            )
            ->where('ingreso_id', $id)
            ->groupBy('listado_ingreso.unidad_medida_id','listado_ingreso.actividad_id')
            ->get();
    }
    public function listadoRecarga($id)
    {
        return Recarga::select('recargas.id', 'recargas.nro_tiquete_anterior', 'recargas.nro_tiquete_nuevo', 'recargas.ingreso_actividad', 'recargas.estado',
                                'nro_extintor',
                                'actividades.nombre_actividad', 'unidades_medida.cantidad_medida','unidades_medida.unidad_medida',
                                'subcategorias.nombre_subCategoria',
                                'categorias.nombre_categoria')
        ->where('ingreso_recarga_id', $id)
        ->join('actividades', 'recargas.activida_recarga_id', '=', 'actividades.id')
        ->join('unidades_medida', 'recargas.capacidad_id', '=', 'unidades_medida.id')
        ->join('subcategorias', 'unidades_medida.sub_categoria_id', '=', 'subcategorias.id')
        ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
        ->get();

        /* return Recarga::where('ingreso_recarga_id', $id)
            ->with('RecargaUsuario', 'UnidadMedida', 'RecargaActividad', 'RecargaIngreso', 'RecargaFuga')->get(); */
    }

    /**
     * Consulta recarga por id
     *
     * @param [type] $id_recarga Primary key de la recarga
     * @return void
     */
    public function consultandoRecarga($id_recarga)
    {
        return Recarga::select([
                'recargas.id',
                'recargas.nro_tiquete_anterior',
                'recargas.nro_tiquete_nuevo',
                'recargas.activida_recarga_id',
                'recargas.fuga_id',
                'recargas.observacion',
                'recargas.nuevo_extintor',
                'nro_extintor',
                'actividades.nombre_actividad',
                'unidades_medida.id as unidades_medida_id',
                'unidades_medida.sub_categoria_id',
                'unidades_medida.cantidad_medida',
                'unidades_medida.unidad_medida',
                'subcategorias.nombre_subCategoria',
                'categorias.nombre_categoria',
                'encargados.nombre_encargado',
                'encargados.numero_serial'
            ])
            ->where('recargas.id', $id_recarga)
            ->join('ingresos', 'ingresos.id', '=', 'recargas.ingreso_recarga_id')
            ->join('encargados', 'encargados.id', '=', 'ingresos.encargado_id')
            ->join('actividades', 'recargas.activida_recarga_id', '=', 'actividades.id')
            ->join('unidades_medida', 'recargas.capacidad_id', '=', 'unidades_medida.id')
            ->join('subcategorias', 'unidades_medida.sub_categoria_id', '=', 'subcategorias.id')
            ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
            ->first();
    }
}
