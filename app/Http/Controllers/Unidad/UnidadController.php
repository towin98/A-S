<?php

namespace App\Http\Controllers\Unidad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Unidad\UnidadCreateRequest;
use App\Models\SubCategoria;
use App\Models\unidad;
use Illuminate\Http\Request;
use App\Models\UnidadMedida;
use Exception;

class UnidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.unidad.unidad');
    }
    public function store(UnidadCreateRequest $request)
    {
        try {
            $error = 'No se puedo realizar el registro';
            $unidad = new UnidadMedida();
            $unidad->unidad_medida = $request->input('unidad_medida');
            $unidad->cantidad_medida = $request->input('cantidad_medida');
            $unidad->sub_categoria_id = $request->input('sub_categoria_id');
            $unidad->save();
            return back()->with('exito', 'Se ha realizado el registro con exito');
        } catch (\Throwable $error) {
            return back()->with($error);
        }
    }
    public function edit($id)
    {
        $subCategoria = SubCategoria::select('id', 'nombre_subCategoria')->get();
        $data = UnidadMedida::findOrFail($id);
        return view('pages.categoria.editarUnidadMedida', compact('data', 'subCategoria'));
    }
    public function update(UnidadCreateRequest $request, $id)
    {

        try {
            $unidad = UnidadMedida::find($id);
            $unidad->unidad_medida = $request->input('unidad_medida');
            $unidad->cantidad_medida = $request->input('cantidad_medida');
            $unidad->sub_categoria_id = $request->input('sub_categoria_id');
            $unidad->estado = $request->input('estado');
            $unidad->update();
            return back()->with('editar', 'Se ha actualizado el registro con exito');
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se puedo completar este evento');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        #Eliminar la Unidad segun su ID
        try {
            $delectUnidad = UnidadMedida::findOrFail($id);
            $delectUnidad->estado = 0;
            $delectUnidad->update();
            return back()->with('error', 'Se elimino con exito');
        } catch (Exception $a) {
            return 'Error';
        }
    }
}
