<?php

namespace App\Http\Controllers\Info;

use App\Http\Controllers\Controller;
use App\Models\ListadoIngreso;
use App\Models\Ingreso;
use App\Models\Recarga;
use Illuminate\Http\Request;
use App\Http\Controllers\Utilities\CambioPartesListado;

class InformacionController extends Controller
{
    use  CambioPartesListado;
    public function index()
    {
        return view('pages.info.Informacion');
    }
    public function search(Request $request)
    {

        if($request['numeroReferencia']){

            $sql = Ingreso::where('ingresos.id',$request['numeroReferencia'])
                ->select('ingresos.*','listado_ingreso.*',
                            'actividades.nombre_actividad','actividades.abreviacion_actividad')
                ->join('listado_ingreso','ingresos.id','=','listado_ingreso.ingreso_id')
                ->join('actividades', 'listado_ingreso.actividad_id', '=', 'actividades.id')
                ->get();
                //return $sql;

                if($sql){
                    return view('pages.info.verInformacion', compact('sql'));
                }else{
                    return back()->with('mensaje', 'No se han encontrado datos con estas credenciales');
                }
        }else{
            return back();
        }



       /*  if ($request->tipo == 'numero_serial') {
            $extintorHistorial = Recarga::select(
                'recargas.id',
                'recargas.nro_tiquete_anterior',
                'recargas.nro_tiquete_nuevo',
                'recargas.observacion',
                'recargas.created_at',
                'ingresos.fecha_recepcion',
                'ingresos.fecha_entrega',
                'ingresos.numero_referencia',
                'ingresos.created_at',
                'unidades_medida.unidad_medida',
                'unidades_medida.cantidad_medida'
            )
                ->join('unidades_medida', 'recargas.capacidad_id', '=', 'unidades_medida.id')
                ->join('ingresos', 'recargas.ingreso_recarga_id', '=', 'ingresos.id')
                ->join('encargados', 'ingresos.encargado_id', '=', 'encargados.id')
                ->where('nro_tiquete_nuevo', $request->numeroEtiqueta)
                ->where('encargados.numero_serial', $request->numeroDocumento)
                ->get();
            if ($extintorHistorial) {
                $listadoCambioPartes = $this->ListadoPartes($extintorHistorial[0]->id);
                $listadoPruebas = $this->ListadoPruebas($extintorHistorial[0]->id);
                //return $listadoCambioPartes;
                return view('pages.info.verInformacion', compact('extintorHistorial', 'listadoCambioPartes', 'listadoPruebas'));
            } else {
                return back()->with('mensaje', 'No se han encontrado datos con estas credenciales');
            }
        } else {
            return 'Consulta con documento interno';
        }  */
    }
}
