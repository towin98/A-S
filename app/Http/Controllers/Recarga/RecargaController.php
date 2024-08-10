<?php

namespace App\Http\Controllers\Recarga;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\{Ingreso, listadoPrueba, listadoRecarga, NumeroTiquete, Recarga, UnidadMedida};
use App\Http\Controllers\Utilities\{CambioPartesListado, ConsultaRecarga, FugaListado};
use Illuminate\Http\Request;
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

    public function setRecargaListado($id)
    {
        $listadoRecarga = $this->listadoRecarga($id);

        $primerTiquete = $this->NumeroEtiqueta($id);
        $clienteS = $this->NumeroSeriaCliente($id);
        $datos = $this->InformacionIngreso($id);
        if (!$primerTiquete) {
            $advertencia =  'Numero de etiquetas terminadas';
            $primerTiquete = 000;
            return view('pages.recarga.verListadoIngreso', compact('datos', 'id', 'clienteS', 'primerTiquete', 'advertencia', 'listadoRecarga'));
        }
        $primerTiquete = $primerTiquete->numero_tiquete;
        return view('pages.recarga.verListadoIngreso', compact('datos', 'id', 'clienteS', 'primerTiquete', 'listadoRecarga'));
    }
    public function store(Request $request)
    {
        /**
         * Para convertir array en string $partes = join(',', $request->cambioParte);
         * para pasar esos string a array $ArrayPartes = (explode(',', $partes));
         */

        if ($request->nro_extintor > 1) {
            return back()->with('advertencia', 'Solo se puede hacer el registro para un extintor.');
        }

        // Validando que no exista ya número de extintor o etiqueta a asignar.
        $numeroTicket = NumeroTiquete::select('id')
            ->where('numero_tiquete', $request->nro_tiquete_nuevo)
            ->whereNotNull('recarga_id')
            ->first();
        if ($numeroTicket) {
            return back()->with('advertencia', "La etiqueta [$request->nro_tiquete_nuevo] ya se encuentra asignada.");
        }

        $recargaTicket = Recarga::select('id')
            ->where('nro_tiquete_anterior', $request->nro_tiquete_anterior)
            ->where('nro_tiquete_anterior', '!=', null)
            ->where('nro_tiquete_anterior', '!=', '')
            ->first();
        if ($recargaTicket) {
            return back()->with('advertencia', "El N° de la tiqueta anterior[$request->nro_tiquete_anterior] ya se encuentra asignada.");
        }

        // Validando ingresos con recargar.
        $ingreso = Ingreso::select(['id', 'numero_total_extintor'])
            ->where('id', $request->ingreso_recarga_id)
            ->first();

        $nRecargas = Recarga::select('id')
            ->where('ingreso_recarga_id', $request->ingreso_recarga_id)
            ->count();

        if ($nRecargas >= $ingreso->numero_total_extintor) {
            return back()->with('advertencia', "Para la Orden de servicio [$ingreso->id] se han completado todas las recargas.");
        }

        try {
            $recarga = new Recarga();

            $validador = Validator::make($request->all(), $recarga::$rules, $recarga::$messagesRules);
            if ($validador->fails()) {
                // El validador ha encontrado errores
                $errores = $validador->errors();
                return back()->withErrors($errores);
            }

            $recarga->nro_tiquete_anterior  = $request->nro_tiquete_anterior;
            $recarga->nro_tiquete_nuevo     = $request->nro_tiquete_nuevo;
            $recarga->nro_extintor          = $request->nro_extintor;
            $recarga->capacidad_id          = $request->capacidad_id;
            $recarga->agente                = $request->agente;
            $recarga->usuario_recarga_id    = $request->usuario_recarga_id;
            $recarga->ingreso_recarga_id    = $request->ingreso_recarga_id;
            $recarga->activida_recarga_id   = $request->activida_recarga_id;
            $recarga->fuga_id               = $request->fuga_id;
            $recarga->observacion           = $request->observacion;
            $recarga->save();

            // Asignando etiqueta nueva a extintor.
            $this->etiqueta($recarga->id, $request->nro_tiquete_nuevo, $request->ingreso_recarga_id);
            $this->saveListChangeParts($recarga->id, $request->cambioParte);
            $this->saveLeakagelist($recarga->id, $request->prueba_id);
            return back()->with('exito', 'Se guardo el registro correctamente');

        } catch (Exception $e) {
            return back()->with('advertencia', 'No se pudo crear el registro: '. $e);
        }
    }
    public function getUnidad($id)
    {
        return UnidadMedida::select('unidades_medida.id', 'unidades_medida.cantidad_medida')
            ->join('subcategorias', 'unidades_medida.sub_categoria_id', '=', 'subcategorias.id')
            ->where('unidades_medida.sub_categoria_id', '=', $id)->get();
    }
    private function etiqueta($idRecarga, $numeroEtiqueta, $ingresoRecargaId = null)
    {
        $actualizarEtiqueta = NumeroTiquete::where('numero_tiquete', $numeroEtiqueta)->whereNull('recarga_id')->first();
        if ($actualizarEtiqueta) {
            $actualizarEtiqueta->recarga_id = $idRecarga;
            $actualizarEtiqueta->update();
        }else{
            // Si no existe es porque el numero de ticket el usuario lo ingreso manual.
            $actualizarEtiqueta = NumeroTiquete::where('ingreso_id', $ingresoRecargaId)->whereNull('recarga_id')->first();
            $actualizarEtiqueta->numero_tiquete = $numeroEtiqueta;
            $actualizarEtiqueta->recarga_id = $idRecarga;
            $actualizarEtiqueta->update();
        }
    }
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
}
