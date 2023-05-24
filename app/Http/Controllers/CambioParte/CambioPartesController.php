<?php

namespace App\Http\Controllers\CambioParte;

use App\Http\Controllers\Controller;
use App\Http\Requests\CambioParte\CambioPartesCreateRequest;
use App\Models\CambioParte;
use Exception;
use Illuminate\Http\Request;

class CambioPartesController extends Controller
{
    public function index()
    {
        return view('pages.cambioParte.cambioParte');
    }
    public function store(CambioPartesCreateRequest $request)
    {
        try {
            $data = CambioParte::create($request->all());
            return back()->with('exito', 'Se completo el registro');
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se pudo completar el registro');
        }
    }
    public function update(CambioPartesCreateRequest $request, $id)
    {
        try {
            $CambioParte = CambioParte::find($id);
            $CambioParte->nombre_parte_cambio = $request->input('nombre_parte_cambio');
            $CambioParte->referencia = $request->input('referencia');
            $CambioParte->update();
            return redirect('cambio')->with('exito', 'Se actualizo con exito el regristro');
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se puedo completar este evento');
        }
    }
    public function destroy($id)
    {
        #Eliminar una Cambio de Parte segun su ID
        try {
            $error = 'Error no se puede eliminar este registro';
            $delectCambioParte = CambioParte::findOrFail($id);
            $delectCambioParte->delete();
            return back()->with('error', 'Se ha eliminado con exito');
        } catch (Exception $error) {
            return back()->with('error', $error);
        }
    }
}
