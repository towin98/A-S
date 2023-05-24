<?php

namespace App\Http\Controllers\Hocol;

use App\Exports\HocolExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utilities\RegistroHocol;
use App\Models\{Hocol, ListadoCarretilla, ListadoPortatil};
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class HocolController extends Controller
{
    use RegistroHocol;
    public function index()
    {
        return view('pages.hocol.formularioIngreso');
    }
    public function store(Request $request)
    {
        // Creamos el objeto
        $data = $this->nuevoRegistro($request);
        $listadoPortatil = $this->listadoPortatil($data, $request->portatil);
        $listadoCarretilla = $this->listadoCarretilla($data, $request->carretilla);

        return back()->with('exito', 'Se ha registrado con exito el ingreso');
    }
    public function verHocol()
    {
        $data = Hocol::select('*')->with('colaborador', 'capacidadExtintor')->get();
        return view('pages.hocol.index')->with('data', json_decode($data, true));
    }
    public function getMore($id)
    {
        $data = Hocol::select('*')->where('id', $id)->with('colaborador', 'capacidadExtintor')->get();
        $data = json_decode($data, true);
        $dataPortatil = ListadoPortatil::where('id_registro_hocol', $id)->with('portatil')->get();
        $dataPortatil = json_decode($dataPortatil, true);
        $listadoCarretilla = ListadoCarretilla::where('id_registro_hocol', $id)->with('carretilla')->get();
        $listadoCarretilla = json_decode($listadoCarretilla, true);
        return view('pages.hocol.informacion', compact('data', 'dataPortatil', 'listadoCarretilla'));
    }
    public function export()
    {
        return Excel::download(new HocolExport, 'hocol.xlsx');
    }
}
