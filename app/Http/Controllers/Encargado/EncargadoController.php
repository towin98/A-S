<?php

namespace App\Http\Controllers\Encargado;

use App\Http\Controllers\Controller;
use App\Http\Requests\Encargado\EncargadoCreateRequest;
use App\Models\Encargado;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EncargadoController extends Controller
{
    public function index()
    {
        return view('pages.encargado.encargado');
    }

    public function store(Request $request)
    {
        try {
            $encargado = new Encargado();
            $encargado->nombre_encargado    = strtoupper($request->input('nombre_encargado'));
            $encargado->numero_celular      = $request->input('numero_celular');
            $encargado->email               = $request->input('email');
            // $encargado->direccion           = $request->input('direccion');
            $encargado->numero_serial       = $request->input('numero_serial');
            $encargado->save();

            return back()->with('exito', 'Se guardo el registro correctamente');
        } catch (\Throwable $th) {
            return back()->withInput()->with('errors', 'No se pudo crear el registro, por favor verifique los datos ingresados.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $encargado = Encargado::find($id);
            $encargado->nombre_encargado = $request->input('nombre_encargado');
            $encargado->numero_celular = $request->input('numero_celular');
            $encargado->email = $request->input('email');
            $encargado->direccion = $request->input('direccion');
            $encargado->numero_serial = $request->input('numero_serial');
            $encargado->update();
            return back()->with('editar', 'Se actualizo el registro correctamente');
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se puedo actualizar este registro');
        }
    }
    public function destroy($id)
    {
        try {
            $delectEncargado = Encargado::findOrFail($id);
            $delectEncargado->delete();
            //return $delectEncargado;
            return back()->with('error', 'Se elimino el registro correctamente');
        } catch (Exception $a) {
            return back()->with('errors', 'No se puedo eliminar este registro');
        }
    }
    public function getClient(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('encargados')
                ->where('nombre_encargado	', 'LIKE', "%{$query}%")
                ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach ($data as $row) {
                $output .= '<li><a href="#">' . $row->nombre_encargado . '</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
}
