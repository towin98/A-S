<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Dotenv\Result\Result;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->paginate(15)]);
    }

    public function nuevoRegistro()
    {
        return view('users.nuevoRegistro');
    }
    public function guardarRegistro(Request $request)
    {
        try {
            $nuevoColaborador = new User();
            $nuevoColaborador->nombre = $request->nombre;
            $nuevoColaborador->apellido = $request->apellido;
            $nuevoColaborador->cargo = $request->cargo;
            $nuevoColaborador->email = $request->email;
            $nuevoColaborador->password = Hash::make($request->password);
            $nuevoColaborador->save();
            return redirect('user')->with('exito', 'He registro con exito el nuevo colaborador A&S');
        } catch (\Throwable $th) {
            return back()->with('error', 'Error al conectar al servidor');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $usuario = User::find($id);
            $usuario->nombre = $request->input('nombre');
            $usuario->apellido = $request->input('apellido');
            $usuario->cargo = $request->input('cargo');
            $usuario->email = $request->input('email');
            $usuario->update();
            return back()->with('editar', 'Se actualizo el registro correctamente');
        } catch (\Throwable $th) {
            return back()->with('errors', 'No se puedo actualizar este registro');
        }
    }
    public function destroy($id)
    {
        try {
            $delectUsuario = User::findOrFail($id);
            $delectUsuario->delete();
            return back()->with('error', 'Se elimino el registro correctamente');
        } catch (Exception $a) {
            return back()->with('errors', 'No se puedo eliminar este registro');
        }
    }
}
