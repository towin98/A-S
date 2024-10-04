<?php

namespace App\Http\Controllers\Ingreso;

use PDF;
use Exception;
use App\Models\Recarga;
use App\Models\Ingreso;
use Illuminate\Http\Request;
use App\Models\NumeroTiquete;
use App\Models\ListadoIngreso;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Utilities\ImprimirTicket;
use App\Http\Controllers\Utilities\CambioPartesListado;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike24\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\compaj;
use Mike42\Escpos\EscposImage;

class IngresoController extends Controller
{
    use ImprimirTicket, CambioPartesListado;

    /**
     * Metodo que genera ticket con resulmen de ingreso.
     *
     * @param string $id_referencia
     * @return void
     */
    public function ticket(string $id_referencia) {
        $actingreso = Ingreso::where('id', $id_referencia)->first();

        if ($actingreso) {
            $ingreso = Ingreso::where('numero_referencia', $id_referencia)
                ->with('Usuario', 'Encargado')
                ->first();

            $data = ListadoIngreso::select(
                    'listado_ingreso.unidad_medida_id',
                    'listado_ingreso.actividad_id',
                    DB::raw('MAX(listado_ingreso.id) as id'),
                    DB::raw('MAX(listado_ingreso.created_at) as created_at'),
                    DB::raw('MAX(listado_ingreso.numero_extintor) as numero_extintor'),
                    DB::raw('MAX(actividades.nombre_actividad) as nombre_actividad'),
                    DB::raw('MAX(subcategorias.nombre_subCategoria) as categoria'),
                    DB::raw('MAX(unidades_medida.unidad_medida) as unidad_medida'),
                    DB::raw('MAX(unidades_medida.cantidad_medida) as cantidad_medida'),
                    DB::raw('SUM(listado_ingreso.numero_extintor) as cantidad')
                )
                ->where('ingreso_id', $id_referencia)
                ->join('actividades', 'listado_ingreso.actividad_id', '=', 'actividades.id')
                ->join('unidades_medida', 'listado_ingreso.unidad_medida_id', '=', 'unidades_medida.id')
                ->join('subcategorias', 'unidades_medida.sub_categoria_id', '=', 'subcategorias.id')
                ->groupBy('listado_ingreso.unidad_medida_id','listado_ingreso.actividad_id')
                ->get();

                // return $data;

                // return view('pdf.pdf', compact('ingreso', 'data', 'id_referencia'));

            // NO SE UTILIZA LIBRERIA PARA IMPRIMIR PORQUE NO SE TIENE SSH ACTIVADO
            $pdf = PDF::loadView('pdf.pdf', [
                'ingreso' => $ingreso,
                'data' => $data,
                'id_referencia' => $id_referencia
            ]);
            return $pdf->stream();
        }
    }

    /**
     * Módulo Ingreso: Crea o consulta ultimo ingreso.
     *
     * @param [type] $id_vendedor Id de usuario logueado
     * @return \stdClass|\App\Models\Ingreso
     */
    public function getIngreso($id_vendedor) {
        $ingreso = DB::table('ingresos')
            ->where('estado', 'recibido')
            ->where('usuario_id', $id_vendedor)
            ->first();

        if ($ingreso)
            return $ingreso;
        else
            $ingreso = new Ingreso();

        $ingreso->fecha_recepcion = now()->format('Y-m-d');
        $ingreso->usuario_id = $id_vendedor;
        $ingreso->estado = 'recibido';
        $ingreso->save();

        return $ingreso;
    }

    public function listadoPorIngreso($idIngreso) {
        $data = Ingreso::where('id', $idIngreso)->with(
            'Listado_Ingreso',
            'Listado_Ingreso.UnidadMedida.SubCategoria.Categoria',
            'Listado_Ingreso.ActividadIngreso',
            'Usuario',
            'Encargado'
        )->get();
        $var = json_encode($data);
        return $var['listado_ingreso'];
        //return view('pages.ingreso.listadoPorIngreso', compact('var'));
    }

    /**
     * Modulo Ingreso: Método que se ejecuta al ingresar en el modulo de Ingreso.
     *
     * @param [type] $id Colaborador
     * @return \Illuminate\View\View
     */
    public function index($id) {
        $crearId = $this->getIngreso($id);

        $ultimoConsecutivo = NumeroTiquete::select([
                'id',
                'numero_tiquete'
            ])
            ->orderBy('id', 'desc')
            ->first();

        $ultimoConsecutivoDisponible = intval($ultimoConsecutivo->numero_tiquete) + 1;
        return view('pages.ingreso.index', compact('crearId', 'ultimoConsecutivoDisponible'));
    }

    /**
     * Modulo Ingreso: Guarda el ingreso.
     *
     * @param Request $request
     * @param [type] $id Orden servicio
     * @return void
     */
    public function update(Request $request, $id) {
        $ingreso = Ingreso::where('id', $id)->first();
        if (!$ingreso) {
            return back()->with('validacion_datos', 'No existe el ingreso, por favor intente de nuevo.');
        }

        $request->merge([
            'numero_referencia' => $ingreso->id,
            'estado'            => 'Produccion'
        ]);

        try {
            $validador = Validator::make($request->all(), Ingreso::$rules, Ingreso::$messagesRules);
            if ($validador->fails()) {
                // El validador ha encontrado errores
                $errores = $validador->errors();
                return back()->withErrors($errores);
            }
        } catch (Exception $th) {
            return back()->with('validacion_datos', 'No se pudo crear el ingreso: ' . $th);
        }

        try {
            // Consultando ultimo número de tiquet
            $numeroEtiqueta = NumeroTiquete::all()->last();

            // Actualizamos el ingreso
            $ingreso->fecha_recepcion       = $request->input('fecha_recepcion');
            $ingreso->fecha_entrega         = $request->input('fecha_entrega');
            $ingreso->encargado_id          = $request->input('encargado_id');
            $ingreso->numero_referencia     = $request->numero_referencia;
            $ingreso->numero_total_extintor = $request->input('numero_total_extintor');
            $ingreso->estado                = "Produccion";
            $ingreso->save();

            // Guardando el listado de extintores ingresados
            $contador = 1;
            for ($nItem=1; $nItem <= $request->numeroFilasExtintores; $nItem++) {
                $listadoIngreso = new ListadoIngreso();
                $listadoIngreso->ingreso_id       = $ingreso->id;
                $listadoIngreso->unidad_medida_id = $request->input('unidad_medida_id_'. $nItem);
                $listadoIngreso->actividad_id     = $request->input('actividad_id_'. $nItem);
                $listadoIngreso->numero_extintor  = $request->input('cantidad_medida_'. $nItem);
                $listadoIngreso->estado           = 1;
                $listadoIngreso->save();

                // Recorriendo la cantidad de cada item ingresado
                for ($nCantExt=0; $nCantExt < $request->input('cantidad_medida_'. $nItem); $nCantExt++) {
                    // Aquí se crea por cada extintor una etiqueta nueva, para reservar en el sistema etiquetas para esa orden
                    $recarga = Recarga::create([
                        'nro_tiquete_anterior'  => $request->input('nro_tiquete_anterior_'. $nItem) ?? null,
                        'nro_tiquete_nuevo'     => ($numeroEtiqueta->numero_tiquete ?? 0 ) + $contador,
                        'nro_extintor'          => 1,
                        'capacidad_id'          => $request->input('unidad_medida_id_'. $nItem),
                        'agente'                => $request->input('agente_'. $nItem),
                        'usuario_recarga_id'    => $ingreso->usuario_id,
                        'ingreso_recarga_id'    => $ingreso->id,
                        'activida_recarga_id'   => $request->input('actividad_id_'. $nItem),
                        'ingreso_actividad'     => 0
                    ]);

                    // la actividad es nuevo codigo 3 guardamos en cambio de partes del extintor configuracion por defecto
                    if ($request->input('actividad_id_'. $nItem) == 3) {
                        $arrIdsListCambiopartes = [1,2,3,4,5,6,8,10,11];
                        $this->saveListChangeParts($recarga->id, $arrIdsListCambiopartes);
                    }

                    //Creando registro de recarga para tener una data adelantada con informacion ingresada en ingreso
                    NumeroTiquete::create([
                        "numero_tiquete" => ($numeroEtiqueta->numero_tiquete ?? 0 ) + $contador,
                        "ingreso_id"     => $ingreso->id,
                        "recarga_id"     => $recarga->id
                    ]);

                    $contador++;
                }
            }

            return back()->with([
                'exito' => 'Se creo con exito la orden de servicio: '. $request->numero_referencia,
                'numero_referencia' => $request->numero_referencia,
            ]);
        } catch (Exception $ex) {
            return back()->with('validacion_datos', 'Error inesperado al crear orden de servicio, intente de nuevo'. $ex);
        }

    }

    /**
     * Método para ingresar extintores para la orden.
     *
     * @param [type] $id Id de la referencia o Orden.
     * @return \Illuminate\View\View
     */
    public function listadoIngreso($id) {
        try {
            $actingreso = Ingreso::where('numero_referencia', $id)->first();
            $total = $actingreso->numero_total_extintor;

            // Consultando listado de ingreso para obtener extintores ingresados hasta el momento.
            $totalExtintoresIngresados = listadoIngreso::where('ingreso_id', $actingreso->id)->sum('numero_extintor');
            return view('pages.listadoIngreso.listadoIngreso', compact('id', 'total', 'totalExtintoresIngresados'));
        } catch (Exception $e) {
            return back()->with('validacion_datos', 'Error inesperado al consultar referencia');
        }
    }

    /**
     * Módulo Ingresos > Ver Ingresos
     *
     * @return View
     */
    public function getEstadoIngreso() {
        try {
            // Buscamos todos los ingresos que se encuentre con los estados diferentes a recibido
            $data = Ingreso::select([
                    'id',
                    'fecha_recepcion',
                    'fecha_entrega',
                    'encargado_id',
                    'usuario_id',
                    'numero_referencia',
                    'numero_total_extintor',
                    'estado'
                ])
                ->with('encargado:id,numero_serial')
                ->where('estado', '=', 'Produccion')
                ->orderBy('id', 'desc')
                ->get();

        } catch (Exception $e) {
            return back()->with('error', 'Error inesperado en la consulta.');
        }
        return view('pages.ingreso.verIngreso', compact('data'));
    }

    /**
     * Método que pasa a producción.
     *
     * @param [type] $id Orden
     * @return void
     */
    public function cambioEstado($id) {

        try {
            $numeroEtiqueta = NumeroTiquete::all()->last();

            $actIngreso = Ingreso::where('id', $id)->first();
            for ($i = 1; $i <= $actIngreso->numero_total_extintor; $i++) {

                // Aquí se crea por cada extintor una etiqueta nueva
                NumeroTiquete::create([
                    "numero_tiquete" => (($numeroEtiqueta->numero_tiquete ?? 0)  + 0) + $i,
                    "ingreso_id"     => $actIngreso->id
                ]);
            }
            if ($actIngreso) {
                $actIngreso->estado = 'Produccion';
                $actIngreso->save();
                return redirect('listIngreso');
            } else {
                return back();
            }
        } catch (Exception $th) {
            return $th;
        }
    }

    /**
     * Módulo Ingreso: Por si el usuario quiere Editar ingreso de orden
     *
     * @param Request $request
     * @param integer $id Order Servicio
     * @return void
     */
    public function actualizarI(Request $request, $id) {
        try {
            $ingreso = Ingreso::where('id', $id)->first();
            $id = $ingreso->id;
            if ($ingreso) {
                $ingreso->fecha_recepcion = $request->input('fecha_recepcion');
                $ingreso->fecha_entrega = $request->input('fecha_entrega');
                // $ingreso->encargado_id  = $request->input('encargado_id');
                // $ingreso->numero_referencia = $ingreso->id;
                // $ingreso->numero_total_extintor = $ingreso->numero_total_extintor;
                // $ingreso->estado = $ingreso->estado;
                // Guardamos en base de datos
                $ingreso->save();

                return redirect('listIngreso');
                //return view('pages.listadoIngreso.listadoIngreso',compact('id','total'));
                //return redirect('listadoIngreso');
            }
        } catch (\Throwable $th) {
            return redirect('listIngreso')->with('error', 'No se actualizo  el ingreso');
        }
    }

    /**
     * Módulo ingreso: Modifica el número total de extintores de la orden antes de pasar a producción.
     *
     * @param Request $request Data recibida
     * @param [type] $id Order Servicio
     * @return void
     */
    public function updateTotalExtintor(Request $request, $id) {
        /** Creamos este metodo para hacer uso de el en varias situaciones */
        try {
            $ingreso = Ingreso::where('id', $id)->first();
            if ($ingreso) {

                /**
                 * Eliminando listado de ingreso porque se va a cambiar el número total de extintores a ingresar
                 */
                listadoIngreso::where('ingreso_id', $ingreso->id)->delete();

                $ingreso->numero_total_extintor = $request->numero_total_extintor;
                $ingreso->estado = 'Produccion';
                $ingreso->save();

                return back();
            }
        } catch (\Throwable $th) {
            return redirect('listIngreso')->with('error', 'No se actualizo  el ingreso');
        }
    }

    public function imprimirTiquete($id) {
        $generarCodigo = NumeroTiquete::select('*')->where('ingreso_id', $id)->get();
        // return $generarCodigo;
        return view('barCode', compact('generarCodigo'));
    }

    public function vistaReporteExtintor() {
        return view('pages.reportes.reporteExtintor');
    }
}
