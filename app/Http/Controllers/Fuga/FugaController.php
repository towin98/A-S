<?php

namespace App\Http\Controllers\Fuga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fuga\FugaCreateRequest;
use App\Models\Fuga;
use Exception;
use Illuminate\Http\Request;

class FugaController extends Controller
{
    public function index()
    {
        return view('pages.fuga.fuga');
    }
    public function store(FugaCreateRequest $request)
    {
        try {
            $data = Fuga::create($request->all());
            return back()->with('exito', 'Se completo el registro');
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se pudo completar el registro');
        }
    }
    public function update(FugaCreateRequest $request, $id)
    {
        try {
            $prueba = Fuga::find($id);
            $prueba->nombre_fuga = $request->input('nombre_fuga');
            $prueba->abreviacion_fuga = $request->input('abreviacion_fuga');
            $prueba->update();
            return redirect('fuga')->with('exito', 'Se actualizo con exito el regristro');
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se puedo completar este evento');
        }
    }
    public function destroy($id)
    {
        #Eliminar una fuga segun su ID
        try {
            $error = 'Error no se puede eliminar este registro';
            $delectPrueba = Fuga::findOrFail($id);
            $delectPrueba->delete();
            return back()->with('error', 'Se ha eliminado con exito');
        } catch (Exception $error) {
            return back()->with('error', $error);
        }
    }
}
