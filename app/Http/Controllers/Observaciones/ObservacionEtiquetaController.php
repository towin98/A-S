<?php

namespace App\Http\Controllers\Observaciones;

use App\Http\Controllers\Controller;
use App\models\NumeroTiquete;
use App\models\Observacion;
use Illuminate\Http\Request;

class ObservacionEtiquetaController extends Controller
{
    public function index()
    {
        return view('pages.Observaciones.verObservaciones');
    }
    public function store(Request $request)
    {

        try {
            $etiqueta = NumeroTiquete::where('numero_tiquete', '=', $request->nro_extintor)->first();
            $etiqueta->recarga_id = null;
            $etiqueta->update();
            $etiqueta = $etiqueta->numero_tiquete + 1;
            $nuevoEtiqueta = new NumeroTiquete();
            $nuevoEtiqueta->numero_tiquete = $etiqueta;
            $nuevoEtiqueta->save();
            $id = $request->numero;
            $data = new Observacion();
            $data->observacion = $request->motivo;
            $data->numero_etiqueta = $request->nro_extintor;
            $data->save();
            $nuevoEtiqueta = $request->nro_extintor;
            $tiquete = $nuevoEtiqueta + 1;
            return redirect('recarga/' . $id, compact('tiquete'));
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se pudo completar el registro');
        }
    }
}
