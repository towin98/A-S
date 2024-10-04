<?php

namespace App\Http\Controllers\Recarga;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\{Ingreso, listadoPrueba, listadoRecarga, NumeroTiquete, Recarga, UnidadMedida};
use App\Http\Controllers\Utilities\{CambioPartesListado, ConsultaRecarga, FugaListado};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\String_;

class RecargaController extends Controller
{
    use CambioPartesListado, FugaListado, ConsultaRecarga;

    public function index()
    {
        $data = Ingreso::select([
                'ingresos.id',
                'ingresos.fecha_recepcion',
                'ingresos.fecha_entrega',
                'encargados.nombre_encargado',
                'ingresos.usuario_id',
                'ingresos.numero_referencia',
                'ingresos.numero_total_extintor',
                'ingresos.estado'
            ])
            ->join('encargados', 'ingresos.encargado_id', '=', 'encargados.id')
            ->where('estado', '=', 'Produccion')
            ->get();

        return view('pages.recarga.verIngresoRecarga', compact('data'));
        //return view('pages.recarga.recarga');
    }

    /**
     * Metodo muestra listado de extintores en el módulo de producción
     *
     * @param [type] $id Id del ingreso
     * @return void
     */
    public function setRecargaListado($id)
    {
        $listadoRecarga = $this->listadoRecarga($id);

        $estadoOrdenServicio = Recarga::select('estado')
            ->where('ingreso_recarga_id', $id)
            ->first();

        $dataCliente    = $this->DatosClienteOrden($id);
        $datos          = $this->InformacionIngreso($id);
        return view('pages.recarga.verListadoIngreso', compact('datos', 'id', 'dataCliente', 'listadoRecarga', 'estadoOrdenServicio'));
    }

    /**
      * Metodo que busca agente y la unidad de medida de extintor por etiqueta anterior si exite.
      *
      * @param [type] $etiquetaAnterior Extintor
      * @return JsonResponse
      */
    public function searchEtiquetaAnterior($etiquetaAnterior){
        try {
            $data = Recarga::select([
                    'id',
                    'ingreso_recarga_id',
                    'capacidad_id'
                ])
                ->with('UnidadMedida', 'RecargaIngreso.Encargado')
                ->where('nro_tiquete_nuevo', $etiquetaAnterior)
                ->first();

            return response()->json([
                "data" => $data
            ],200);
        } catch (Exception $ex) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors'  => [
                    'No se encontraron registros'
                ]
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $arrErrores = [];

        if (!$request->filled('recarga_id')) {
            $arrErrores[] = "La recarga es requerida";
        }

        if (!$request->filled('nro_tiquete_nuevo')) {
            $arrErrores[] = "El Número de tiquete anterior es requerido.";
        }

        if (!isset($request->cambioParte) || !is_array($request->cambioParte)) {
            $arrErrores[] = "Error en el envio del parámetro cambio de partes.";
        }

        if (!isset($request->pruebas) || !is_array($request->pruebas)) {
            $arrErrores[] = "Error en el envio del parámetro listado de pruebas.";
        }

        if (count($arrErrores) > 0) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors'  => $arrErrores
            ], 422);
        }

        try {

            // Validando que no exista ya número de extintor o etiqueta a asignar.
            $numeroTicket = NumeroTiquete::select('id')
                ->where('numero_tiquete', $request->nro_tiquete_nuevo)
                ->whereNull('recarga_id')
                ->first();
            if ($numeroTicket) {
                $arrErrores[] = "La etiqueta [$numeroTicket->nro_tiquete_nuevo] ya se encuentra asignada.";
                // return back()->with('advertencia', "La etiqueta [$request->nro_tiquete_nuevo] ya se encuentra asignada.");
            }

            $recargaTicket = Recarga::select('id')
                ->where('id', '!=', $request->recarga_id)
                ->where('nro_tiquete_anterior', $request->nro_tiquete_anterior)
                ->where('nro_tiquete_anterior', '!=', null)
                ->where('nro_tiquete_anterior', '!=', '')
                ->first();
            if ($recargaTicket) {
                $arrErrores[] = "El N° de la tiqueta anterior[$request->nro_tiquete_anterior] ya se encuentra asignada, por favor corrija.";
            }

            if (count($arrErrores) > 0) {
                return response()->json([
                    'message' => 'Error de Validación de Datos',
                    'errors'  => $arrErrores
                ], 422);
            }

            Recarga::where('id', $request->recarga_id)->update([
                "nro_tiquete_anterior"  => $request->nro_tiquete_anterior,
                "usuario_recarga_id"    => Auth::user()->id, // Tecnico que realizo el procedimiento
                "fuga_id"               => $request->fuga_id,
                "observacion"           => $request->observacion,
                "ingreso_actividad"     => 1, // Indica se ha procesado,
                "nuevo_extintor"        => $request->nuevo_extintor,
                "estado"                => $request->estado
            ]);

            $this->saveListChangeParts($request->recarga_id, $request->cambioParte);
            $this->saveLeakagelist($request->recarga_id, $request->pruebas);

            return response()->json([
                "message" => "Registro exitoso"
            ],201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error inesperado en el servidor',
                'errors'  => [
                    "No se pudo crear el registro:" . $e
                ]
            ], 500);
        }
    }

    public function getUnidad($id)
    {
        return UnidadMedida::select([
                'unidades_medida.id',
                'unidades_medida.cantidad_medida',
                'unidad_medida'
            ])
            ->join('subcategorias', 'unidades_medida.sub_categoria_id', '=', 'subcategorias.id')
            ->where('unidades_medida.sub_categoria_id', '=', $id)
            ->get();
    }

    //UTLIMA MODIDICACION 2024/08/00 - REINGENIERIA RECARGAS - CRISTIAN SEGURA
    // private function etiqueta($idRecarga, $numeroEtiqueta, $ingresoRecargaId = null)
    // {
    //     $actualizarEtiqueta = NumeroTiquete::where('numero_tiquete', $numeroEtiqueta)->whereNull('recarga_id')->first();
    //     if ($actualizarEtiqueta) {
    //         $actualizarEtiqueta->recarga_id = $idRecarga;
    //         $actualizarEtiqueta->update();
    //     }else{
    //         // Si no existe es porque el numero de ticket el usuario lo ingreso manual.
    //         $actualizarEtiqueta = NumeroTiquete::where('ingreso_id', $ingresoRecargaId)->whereNull('recarga_id')->first();
    //         $actualizarEtiqueta->numero_tiquete = $numeroEtiqueta;
    //         $actualizarEtiqueta->recarga_id = $idRecarga;
    //         $actualizarEtiqueta->update();
    //     }
    // }

    /**Para obtener la informacion de la recargas que pertenecen a un ingreso */
    public function informacionListadoRecarga($id)
    {

        $listadoRecarga = $this->listadoRecarga($id);
        $listadoRecarga = json_decode($listadoRecarga, true);
        return $listadoRecarga;
        //return view('pages.recarga.listadoRecarga')->with('listadoRecarga', json_decode($listadoRecarga, true));
    }

    /**
     * Método que permite eliminar un extintor de una orden.
     *
     * @param integer $id Id recarga a eliminar
     * @return void
     */
    public function eliminarExtintorOrden(int $id){
        try {
            $recarga = Recarga::find($id);
            if ($recarga) {
                listadoRecarga::where('recarga_id', $id)->delete();
                listadoPrueba::where('recarga_id', $id)->delete();

                // Liberando número de tiquete de extintor asignado.
                NumeroTiquete::where('recarga_id', $id)->update([
                    'recarga_id' => null
                ]);
            }else{
                return back()->with('advertencia_eliminar_extintor_orden', 'No se encontró la recarga.');
            }
            $recarga->delete();
            return back()->with('exito_eliminar_extintor_orden', 'Se elimino exitosamente.');
        } catch (Exception $e) {
            return back()->with('advertencia_eliminar_extintor_orden', 'Error inesperado al eliminar registro.'.$e);
        }
    }

    /**
     * Consultando recarga por llave Primary key
     *
     * @param [type] $id_recarga
     * @return void
     */
    public function buscarRecarga($id_recarga){
        try {

            //Consultando listado de cambio de partes extintor
            $listadoCambioPartes = listadoRecarga::select('cambio_parte_id')
                ->where('recarga_id', $id_recarga)
                ->get();

            //Consultando listado de pruebas realizadas a extintor
            $listadoPruebas = listadoPrueba::select('prueba_id')
                ->where('recarga_id', $id_recarga)
                ->get();

            $data = $this->consultandoRecarga($id_recarga);

            return response()->json([
                "data"          => $data,
                "cambiopartes"  => $listadoCambioPartes,
                "pruebas"       => $listadoPruebas
            ],200);

        } catch (Exception $ex) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors'  => [
                    'No se encontraron registros'.$ex
                ]
            ], 404);
        }
    }

    public function cerrarOrden(Request $request){

        try {
            $arrErrores = [];

            $nRecargas = Recarga::select('id')
                ->where('ingreso_recarga_id', $request->idIngreso)
                ->where('ingreso_actividad', 0)
                ->get()
                ->count();

            if ($nRecargas > 0) {
                $arrErrores[] = "Debe completar el ingreso de la totalidad de actividades de los extintores.";
            }

            if (count($arrErrores) > 0) {
                return response()->json([
                    'message' => 'Error de Validación de Datos',
                    'errors'  => $arrErrores
                ], 422);
            }

            //Aqui cambio el estado de la orden-recarga en 0 porque para indicar que se cerro la orden
            Recarga::select('id')
            ->where('ingreso_recarga_id', $request->idIngreso)
            ->update([
                'estado' => 0
            ]);

            return response()->json([
                "message" => "La orden de servicio ". $request->idIngreso . " se ha cerrado."
            ],201);

        } catch (Exception $ex) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors'  => [
                    'No se encontraron registros'.$ex
                ]
            ], 404);
        }
    }
}
