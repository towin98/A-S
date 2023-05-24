<?php

namespace App\Http\Controllers\Prueba;

use App\Http\Controllers\Controller;
use App\Http\Requests\Prueba\PruebaCreateRequest;
use App\Models\Prueba;
use Exception;
use Illuminate\Http\Request;

class PruebaController extends Controller
{
    public function index()
    {
        return view('pages.prueba.prueba');
    }
    public function store(PruebaCreateRequest $request)
    {
        try {
            $data = Prueba::create($request->all());
            return back()->with('exito', 'Se completo el registro');
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se pudo completar el registro');
        }
    }
    public function update(PruebaCreateRequest $request, $id)
    {
        try {
            $prueba = Prueba::find($id);
            $prueba->nombre_prueba = $request->input('nombre_prueba');
            $prueba->abreviacion_prueba = $request->input('abreviacion_prueba');
            $prueba->update();
            return redirect('prueba')->with('exito','Se actualizo con exito el regristro');
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se puedo completar este evento');
        }
    }
    public function destroy($id)
    {
        #Eliminar una prueba segun su ID
        try {
            $error='Error no se puede eliminar este registro';
            $delectPrueba = Prueba::findOrFail($id);
            $delectPrueba->delete();
            return back()->with('exito', 'Se ha eliminado con exito');
        } catch (Exception $error) {
            return back()->with('error',"Registro en uso, No se puede eliminar");
        }
    }
}
