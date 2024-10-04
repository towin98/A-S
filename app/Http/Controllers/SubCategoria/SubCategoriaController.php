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

    /**
     * Deletes a SubCategoria record by its ID and sets its state to inactive.
     *
     * @param int $id The ID of the SubCategoria to be deleted.
     *
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page with a success or error message.
     *
     * @throws \Exception If the SubCategoria cannot be deleted.
     */
    public function destroy($id)
    {
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

    /**
     * Metodo que consulta agentes de extintor.
     *
     * @return JsonResponse
     */
    public function buscarAgentes() {
        try {
            $arrData = SubCategoria::select([
                'subcategorias.id',
                'subcategorias.nombre_subCategoria',
                'subcategorias.categoria_id',
                'subcategorias.abreviacion',
                'subcategorias.estado',
                'categorias.nombre_categoria'
            ])
                ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
                ->where('subcategorias.estado', '=', 1)
                ->get();

                return response()->json([
                    "data" => $arrData
                ],200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error de Validación de Datos',
                'errors'  => [
                    'No se encontraron registros'
                ]
            ], 404);
        }
    }

}
