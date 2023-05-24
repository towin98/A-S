<?php

namespace App\Http\Controllers\SubCategoria;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoria\SubCategoriaCreateRequest;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\SubCategoria;
use Exception;

class SubCategoriaController extends Controller
{
    public function index()
    {
        return view('pages.subCategoria.subCategoria');
    }
    public function store(SubCategoriaCreateRequest $request)
    {
        try {
            $error = 'No se puedo realizar el registro';
            $subCategoria = new SubCategoria();
            $subCategoria->nombre_subCategoria = $request->input('nombre_subCategoria');
            $subCategoria->abreviacion = $request->input('abreviacion');
            $subCategoria->categoria_id = $request->input('categoria_id');
            $subCategoria->save();
            return back()->with('exito', 'El registro se realizo con exito');
        } catch (\Throwable $error) {
            return back()->with($error);
        }
    }
    public function update(SubCategoriaCreateRequest $request, $id)
    {
        try {
            $subCategoria = SubCategoria::find($id);
            $subCategoria->nombre_subCategoria = $request->input('nombre_subCategoria');
            $subCategoria->abreviacion = $request->input('abreviacion');
            $subCategoria->categoria_id = $request->input('categoria_id');
            $subCategoria->estado = $request->input('estado');
            $subCategoria->update();
            return redirect('subCategoria')->with('editar', 'Se ha realizado la actualizacion con exito');
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se puedo completar este evento');
        }
    }
    public function destroy($id)
    {
        #Eliminar un cliente segun su ID
        try {
            $error = 'Error no se puede eliminar este registro';
            $delectsubCategoria = SubCategoria::findOrFail($id);
            $delectsubCategoria->estado = 0;
            $delectsubCategoria->update();
            return back()->with('error', 'Se ha inhabilitado con exito');
        } catch (Exception $error) {
            return back()->with('error', $error);
        }
    }
}
