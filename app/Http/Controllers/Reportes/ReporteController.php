<?php

namespace App\Http\Controllers\Reportes;

use Exception;
use App\Models\Recarga;
use App\Models\Encargado;
use App\Models\listadoPrueba;
use App\Models\listadoRecarga;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Ingreso;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function vistaReporteExtintor(){
        return view('pages.reportes.reporteExtintor');
    }

    /**
     * Genera reporte por etiqueta del extintor detallado.
     *
     * @param string $search_numero_etiqueta
     * @return JsonResponse
     */
    public function reporteEtiquetaExtintor(string $search_numero_etiqueta): JsonResponse {
        $arrInfoEtiquetas = [];
        $propietario = "";

        $recarga = Recarga::select([
                'id',
                'nro_tiquete_anterior',
                'nro_tiquete_nuevo',
                'ingreso_recarga_id',
                'activida_recarga_id',
                'fuga_id',
                'capacidad_id',
                'created_at'
            ])
            ->with('RecargaIngreso.Encargado')
            ->with('RecargaActividad')
            ->with('UnidadMedida.SubCategoria.Categoria')
            ->with('RecargaFuga')
            ->where('nro_tiquete_anterior', $search_numero_etiqueta)
            ->orWhere('nro_tiquete_nuevo', $search_numero_etiqueta)
            ->first();

        if ($recarga) {

            $propietario = $recarga->RecargaIngreso->Encargado->numero_serial." - ".$recarga->RecargaIngreso->Encargado->nombre_encargado;

            $arrInfoEtiquetas[] = $this->reporteExtintor($recarga);

            // Recorrido hacia adelante.
            $etiquetaNueva = $recarga->nro_tiquete_nuevo;

            // Re crea un bluque infito para almacenar las etiquetas encontradas.
            for ($i=0; $i != "infito_etiquetas_nuevas"; $i++) {

                $recargaNuevo = Recarga::select([
                        'id',
                        'nro_tiquete_anterior',
                        'nro_tiquete_nuevo',
                        'ingreso_recarga_id',
                        'activida_recarga_id',
                        'fuga_id',
                        'capacidad_id',
                        'created_at'
                    ])
                    ->with('RecargaActividad')
                    ->with('UnidadMedida.SubCategoria.Categoria')
                    ->with('RecargaFuga')
                    ->where('nro_tiquete_anterior', $etiquetaNueva)
                    ->first();

                if ($recargaNuevo) {
                    $etiquetaNueva = $recargaNuevo->nro_tiquete_nuevo;

                    $arrInfoEtiquetas[] = $this->reporteExtintor($recargaNuevo);
                }else{
                    break;
                }
            }

            $etiquetaAterior = $recarga->nro_tiquete_anterior;

            // Re crea un bluque infito para almacenar las etiquetas encontradas.
            for ($i=0; $i != "infito_etiquetas_anteriores"; $i++) {

                $recargaAnterior = Recarga::select([
                    'id',
                    'nro_tiquete_anterior',
                    'nro_tiquete_nuevo',
                    'ingreso_recarga_id',
                    'activida_recarga_id',
                    'fuga_id',
                    'capacidad_id',
                    'created_at'
                ])
                ->with('RecargaActividad')
                ->with('UnidadMedida.SubCategoria.Categoria')
                ->with('RecargaFuga')
                ->where('nro_tiquete_nuevo', $etiquetaAterior)
                ->first();

                if ($recargaAnterior) {
                    $etiquetaAterior = $recargaAnterior->nro_tiquete_anterior;

                    $arrEtiquetasAnteriores = $this->reporteExtintor($recargaAnterior);

                    // Añade elemento al principio de array
                    array_unshift($arrInfoEtiquetas, $arrEtiquetasAnteriores);

                }else{
                    break;
                }
            }
        }

        return response()->json([
            "data"        => $arrInfoEtiquetas,
            "propietario" => $propietario
        ],200);
    }

    /**
      * Método que contruye info data del extintor detallamente.
      *
      * @param Object $recarga
      * @return array
      */
    private function reporteExtintor(Object $recarga): array {

        $arrCambioPartes = [];
        $arrPrueba = [];
        $arrFugas = [];

        // Cambio de partes del extintor - listado_recarga
        $listadosRecarga = listadoRecarga::select('cambio_parte_id')
            ->where('recarga_id', $recarga->id)
            ->get();
        foreach ($listadosRecarga as $listadoRecarga) {
            $id = $listadoRecarga->cambio_parte_id;
            $arrCambioPartes[$id] = 'X';
        }

        // Prueba
        $listadoPruebas = listadoPrueba::select(['id','recarga_id','prueba_id'])
            ->with('getPrueba')
            ->where('recarga_id', $recarga->id)
            ->get();

        foreach ($listadoPruebas as $listadoPrueba) {
            switch (strtoupper($listadoPrueba->getPrueba->abreviacion_prueba)) {
                case 'PI':
                    $arrPrueba['PI'] = 'X';
                    break;
                case 'HI':
                    $arrPrueba['HI'] = 'X';
                    break;
                case 'HE':
                    $arrPrueba['HE'] = 'X';
                    break;
            }
        }

        // Fuga
        $arrFugas = [];
        if (count($recarga->RecargaFuga) > 0) {
            switch ($recarga->RecargaFuga[0]->abreviacion_fuga) {
                case 'A':
                    $arrFugas['A'] = 'X';
                    break;
                case 'B':
                    $arrFugas['B'] = 'X';
                    break;
                case 'C':
                    $arrFugas['C'] = 'X';
                    break;
                case 'A M':
                    $arrFugas['A M'] = 'X';
                    break;
            }
        }

        $agente = $recarga?->UnidadMedida?->SubCategoria?->nombre_subCategoria."-".$recarga?->UnidadMedida?->SubCategoria?->categoria?->nombre_categoria;

        $arrInfoEtiquetas = [
            'nro_tiquete_anterior'  => $recarga->nro_tiquete_anterior,
            'nro_tiquete_nuevo'     => $recarga->nro_tiquete_nuevo,
            'ingreso_recarga_id'    => $recarga->ingreso_recarga_id,
            'agente'                => $agente,
            'capacidad_producto'    => $recarga?->UnidadMedida?->cantidad_medida,
            'unidad_medida'         => $recarga?->UnidadMedida?->unidad_medida,
            'nombre_actividad'      => $recarga?->RecargaActividad[0]?->nombre_actividad,

            // Cambio de partes del extintor
            'parte_1'               => array_key_exists(1, $arrCambioPartes) ? $arrCambioPartes[1] : '',
            'parte_2'               => array_key_exists(2, $arrCambioPartes) ? $arrCambioPartes[2] : '',
            'parte_3'               => array_key_exists(3, $arrCambioPartes) ? $arrCambioPartes[3] : '',
            'parte_4'               => array_key_exists(4, $arrCambioPartes) ? $arrCambioPartes[4] : '',
            'parte_5'               => array_key_exists(5, $arrCambioPartes) ? $arrCambioPartes[5] : '',
            'parte_6'               => array_key_exists(6, $arrCambioPartes) ? $arrCambioPartes[6] : '',
            'parte_7'               => array_key_exists(7, $arrCambioPartes) ? $arrCambioPartes[7] : '',
            'parte_8'               => array_key_exists(8, $arrCambioPartes) ? $arrCambioPartes[8] : '',
            'parte_9'               => array_key_exists(9, $arrCambioPartes) ? $arrCambioPartes[9] : '',
            'parte_10'              => array_key_exists(10, $arrCambioPartes) ? $arrCambioPartes[10] : '',
            'parte_11'              => array_key_exists(11, $arrCambioPartes) ? $arrCambioPartes[11] : '',
            'parte_12'              => array_key_exists(12, $arrCambioPartes) ? $arrCambioPartes[12] : '',
            'parte_13'              => array_key_exists(13, $arrCambioPartes) ? $arrCambioPartes[13] : '',

            // Pruebas
            'PI'                    => array_key_exists('PI', $arrPrueba) ? $arrPrueba['PI'] : '',
            'HI'                    => array_key_exists('HI', $arrPrueba) ? $arrPrueba['HI'] : '',
            'HE'                    => array_key_exists('HE', $arrPrueba) ? $arrPrueba['HE'] : '',

            // Fugas
            'niple'                 => array_key_exists('A', $arrFugas) ? $arrFugas['A'] : '',
            'recipiente'            => array_key_exists('B', $arrFugas) ? $arrFugas['B'] : '',
            'valvula'               => array_key_exists('C', $arrFugas) ? $arrFugas['C'] : '',
            'acople_manguera'       => array_key_exists('A M', $arrFugas) ? $arrFugas['A M'] : '',

            'fecha'                 => $recarga->created_at->format('Y-m-d')
        ];

        return $arrInfoEtiquetas;
    }

    public function vistaReporteClienteExtintor(){
        return view('pages.reportes.reporteClienteExtintor');
    }

    public function reporteClienteOrdenesServicio(Request $request) {

        $arrData = [];
        $arrErrores = [];
        $propietario = "";

        // Validaciones
        if(!$request->filled('id_cliente') || $request->id_cliente == ''){
            $arrErrores[] = "Debe seleccionar el cliente.";
        }

        if(!$request->filled('fecha_desde') || $request->fecha_desde == ''){
            $arrErrores[] = "Debe enviar fecha desde.";
        }

        if(!$request->filled('fecha_hasta') || $request->fecha_hasta == ''){
            $arrErrores[] = "Debe enviar fecha desde.";
        }

        if (!empty($arrErrores)) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors'  => $arrErrores
            ], 409);
        }

        // Validando Cliente
        $cliente = Encargado::select([
                'numero_serial',
                'nombre_encargado'
            ])
            ->where('id', $request->id_cliente)
            ->first();
        if (!$cliente) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors'  => ['El paciente seleccionado no existe.']
            ], 409);
        }

        $propietario = $cliente->numero_serial." - ".$cliente->nombre_encargado;

        $ingresosCliente = Ingreso::select(['id', 'numero_referencia', 'encargado_id', 'fecha_recepcion'])
            ->with('Ingreso_Recarga.UnidadMedida')
            ->with('Ingreso_Recarga.RecargaActividad')
            ->where('encargado_id', $request->id_cliente)
            ->whereBetween('fecha_recepcion', [$request->fecha_desde . ' 00:00:00', $request->fecha_hasta . ' 23:59:59'])
            ->get();

        $arrData = [];

        $color1 = "#c4efb9"; // green
        $color2 = "#fffcd7"; // yellow
        $color  = $color1;
        foreach ($ingresosCliente as $ingresoCliente) {
            if ($color == $color1) {
                $color = $color2;
            }else{
                $color = $color1;
            }
            foreach ($ingresoCliente->Ingreso_Recarga as $recarga) {

                $agente = $recarga->UnidadMedida?->SubCategoria?->nombre_subCategoria."-".$recarga->UnidadMedida?->SubCategoria?->categoria?->nombre_categoria;

                $total = 1;
                if (isset($arrData[$ingresoCliente->numero_referencia][$recarga->capacidad_id])) {
                    $total = $arrData[$ingresoCliente->numero_referencia][$recarga->capacidad_id]['total'] + 1;
                }

                $arrData[$ingresoCliente->numero_referencia][$recarga->capacidad_id] = [
                    'orden_servicio'        => $ingresoCliente->numero_referencia,
                    'agente'                => $agente,
                    'capacidad_producto'    => $recarga->UnidadMedida?->cantidad_medida,
                    "total"                 => $total,
                    'color'                 => $color
                ];
            }
        }

        return response()->json([
            "data"        => $arrData,
            "propietario" => $propietario
        ],200);
    }

    public function vistaReporteOrdenServicio(){
        return view('pages.reportes.reporteOrdenServicio');
    }

    /**
     * Método que genera reporte de una orden.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function reporteOrden(Request $request): JsonResponse {

        $arrErrores = [];
        $arrData = [];

        if(!$request->filled('id_orden')){
            $arrErrores[] = "La orden es requerida.";
        }

        if (!empty($arrErrores)) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors'  => $arrErrores
            ], 409);
        }

        $ingreso = Ingreso::select([
                'id',
                'fecha_recepcion',
                'fecha_entrega',
                'encargado_id'
            ])
            ->with('Encargado')
            ->with('Ingreso_Recarga')
            ->where('id', $request->id_orden)
            ->first();

        if ($ingreso) {
            try {
                $arrData['id_orden']        = $ingreso->id;
                $arrData['fecha_recepcion'] = $ingreso->fecha_recepcion;
                $arrData['fecha_entrega']   = $ingreso->fecha_entrega;

                $arrData['cliente']         = $ingreso->Encargado->nombre_encargado;
                $arrData['nit']             = $ingreso->Encargado->numero_serial;
                $arrData['direccion']       = $ingreso->Encargado->direccion;

                $arrData['contacto']        = $ingreso->Encargado->numero_celular;
                $arrData['email']           = $ingreso->Encargado->email;

                foreach ($ingreso->Ingreso_Recarga as $recarga) {

                    $agente = $recarga->UnidadMedida?->SubCategoria?->nombre_subCategoria."-".$recarga->UnidadMedida?->SubCategoria?->categoria?->nombre_categoria;

                    $total = 1;
                    if (isset($arrData['extintores'][$recarga->capacidad_id])) {
                        $total = $arrData['extintores'][$recarga->capacidad_id]['total'] + 1;
                    }

                    $arrData['extintores'][$recarga->capacidad_id] = [
                        'agente'                => $agente,
                        'capacidad_producto'    => $recarga->UnidadMedida?->cantidad_medida,
                        'unidad_medida'         => $recarga->UnidadMedida?->unidad_medida,
                        "total"                 => $total
                    ];
                }

                $totalExtintores = 0;
                foreach ($arrData['extintores'] as $extintor) {
                    $totalExtintores += $extintor['total'];
                }

                $arrData['total_extintores'] = $totalExtintores;
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Error de Validación de Datos',
                    'errors'  => [
                        'Error inesperado'. $e
                    ]
                ], 500);
            }
        }else{
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors'  => [
                    'No se encontraron registros con la Orden:'.$request->id_orden
                ]
            ], 404);
        }

        return response()->json([
            "data"        => $arrData,
        ],200);
    }
}
