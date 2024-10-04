<?php

namespace App\Http\Controllers\Actividad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Actividad\ActividadesCreateRequest;
use App\Models\Actividad;
use Exception;
use Illuminate\Http\Request;

class ActividadesController extends Controller
{
    public function index()
    {
        return view('pages.actividad.actividad');
    }
    public function store(ActividadesCreateRequest $request)
    {
        try {
            $data = Actividad::create($request->all());
            return back()->with('exito', 'Se completo el registro');
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se pudo completar el registro');
        }
    }
    public function update(ActividadesCreateRequest $request, $id)
    {
        try {
            $prueba = Actividad::find($id);
            $prueba->nombre_actividad = $request->input('nombre_actividad');
            $prueba->abreviacion_actividad = $request->input('abreviacion_actividad');
            $prueba->update();
            return back()->with('editar', 'Se actualizo el registro correctamente');
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se puedo completar este evento');
        }
    }
    public function destroy($id)
    {
        #Eliminar una Actividad segun su ID
        try {
            $error = 'Error no se puede eliminar este registro';
            $delectPrueba = Actividad::findOrFail($id);
            $delectPrueba->delete();
            return back()->with('error', 'Se ha eliminado con exito');
        } catch (Exception $error) {
            return back()->with('errors', 'No se puedo eliminar este registro');
        }
    }

    /**
     * Consultando actividades.
     *
     * @return JsonResponse
     */
    public function actividades(){
        try {
            $arrData = Actividad::select([
                    'id',
                    'nombre_actividad',
                    'abreviacion_actividad'
                ])
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
