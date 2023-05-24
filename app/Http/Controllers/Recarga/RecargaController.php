<?php

namespace App\Http\Controllers\Recarga;

use App\Http\Controllers\Controller;
use App\Models\{Ingreso, NumeroTiquete, Recarga, UnidadMedida};
use App\Http\Controllers\Utilities\{CambioPartesListado, ConsultaRecarga, FugaListado};
use Illuminate\Http\Request;


class RecargaController extends Controller
{
    use CambioPartesListado, FugaListado, ConsultaRecarga;
    public function index()
    {
        $data = Ingreso::select('ingresos.id', 'ingresos.fecha_recepcion', 'ingresos.fecha_entrega', 'encargados.nombre_encargado', 'ingresos.usuario_id', 'ingresos.numero_referencia', 'ingresos.numero_total_extintor', 'ingresos.estado')
            ->join('encargados', 'ingresos.encargado_id', '=', 'encargados.id')
            ->where('estado', '=', 'Produccion')->get();
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


        #try {
        $recarga = new Recarga();
        $recarga->nro_tiquete_anterior = $request->nro_tiquete_anterior;
        $recarga->nro_tiquete_nuevo = $request->nro_tiquete_nuevo;
        $recarga->nro_extintor = $request->nro_extintor;
        $recarga->capacidad_id = $request->capacidadProducto;
        $recarga->agente = $request->agente;
        $recarga->usuario_recarga_id = $request->usuario_recarga_id;
        $recarga->ingreso_recarga_id = $request->ingreso_recarga_id;
        $recarga->activida_recarga_id = $request->activida_recarga_id;
        $recarga->fuga_id = $request->fuga_id;
        $recarga->observacion = $request->observacion;
        $recarga->save();
        $this->etiqueta($recarga->id, $request->nro_tiquete_nuevo);
        $this->saveListChangeParts($recarga->id, $request->cambioParte);
        $this->saveLeakagelist($recarga->id, $request->prueba_id);
        return back()->with('exito', 'Se guardo el registro correctamente');
        #} catch (\Throwable $th) {
        return back()->with('errors', 'No se pudo crear el registro');
        #}
    }
    public function getUnidad($id)
    {
        return UnidadMedida::select('unidades_medida.id', 'unidades_medida.cantidad_medida')
            ->join('subcategorias', 'unidades_medida.sub_categoria_id', '=', 'subcategorias.id')
            ->where('unidades_medida.sub_categoria_id', '=', $id)->get();
    }
    private function etiqueta($idRecarga, $numeroEtiqueta)
    {
        $actualizarEtiqueta = NumeroTiquete::where('numero_tiquete', $numeroEtiqueta)->first();
        $actualizarEtiqueta->recarga_id = $idRecarga;
        $actualizarEtiqueta->update();
    }
    /**Para obtener la informacion de la recargas que pertenecen a un ingreso */
    public function informacionListadoRecarga($id)
    {

        $listadoRecarga = $this->listadoRecarga($id);
        $listadoRecarga = json_decode($listadoRecarga, true);
        return $listadoRecarga;
        //return view('pages.recarga.listadoRecarga')->with('listadoRecarga', json_decode($listadoRecarga, true));
    }
}
