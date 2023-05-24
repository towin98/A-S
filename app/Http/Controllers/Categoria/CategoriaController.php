<?php

namespace App\Http\Controllers\Categoria;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categoria\CategoriaCreateRequest;
use Illuminate\Http\Request;
use App\Models\Categoria;
use Exception;

class CategoriaController extends Controller
{

    public function index()
    {
        return view('pages.categoria.categoria');
    }
    public function store(CategoriaCreateRequest $request)
    {
        try {
            $data = Categoria::create($request->all());
            return back()->with('exito', 'Se completo el registro');
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se pudo completar el registro');
        }
    }
    public function update(CategoriaCreateRequest $request, $id)
    {
        return 'Hola';
        try {
            $categoria = Categoria::find($id);
            $categoria->nombre_categoria = $request->input('nombre_categoria');
            $categoria->estado = $request->input('estado');
            $categoria->update();
            return redirect('categoria');
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se puedo completar este evento');
        }
    }
    public function destroy($id)
    {
        #Eliminar una categoria segun su ID
        try {
            $error = 'Error no se puede eliminar este registro';
            $delectCategoria = Categoria::findOrFail($id);
            $delectCategoria->estado = 0;
            $delectCategoria->update();
            return back()->with('error', 'Se ha inhabilitado la categoria con exito');
        } catch (Exception $error) {
            return back()->with('error', $error);
        }
    }
}
