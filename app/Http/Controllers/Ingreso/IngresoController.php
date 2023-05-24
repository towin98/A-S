<?php

namespace App\Http\Controllers\Ingreso;

use App\Http\Controllers\Controller;
use App\Models\Ingreso;
use App\Models\ListadoIngreso;
use App\Models\NumeroTiquete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike24\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\compaj;
use Mike42\Escpos\EscposImage;
use App\Http\Controllers\Utilities\ImprimirTicket;
use PDF;

class IngresoController extends Controller
{
    use ImprimirTicket;


    public function ticket($id_referencia)
    {
            $numeroEtiqueta = NumeroTiquete::all()->last();

            $actingreso = Ingreso::where('id', $id_referencia)->first();
            /**
            * Valida la informacion y crea los nuevos tickets para el ingreso
            */


            for ($i = 1; $i <= $actingreso->numero_total_extintor; $i++) {
                $nuevaEtiqueta = new NumeroTiquete();
                $nuevaEtiqueta->numero_tiquete = $numeroEtiqueta->numero_tiquete + $i;
                $nuevaEtiqueta->ingreso_id = $actingreso->id;
                $nuevaEtiqueta->save();
            }
            /**
            * Cambia el estado del ingreso y guarda el registro
            */

                /**
                * Ingresa a imprimir la factura
                */

              /*   $ingreso = Ingreso::where('numero_referencia', $id_referencia)
                ->with('Usuario', 'Encargado')
                ->first();

                $nombreImpresora = ("SAT 22TUS");
                $connector = new WindowsPrintConnector($nombreImpresora);
                $impresora = new Printer($connector);

                $data = $this->obtenerListadoIngreso($id_referencia); */
                //return $data;
/*
                $impresora->setJustification(Printer::JUSTIFY_CENTER);
                $logo2 =  EscposImage::load("C:\Users\hp\Documents\GitHub\ProyectoExtintores\public\barra.png", false);
                $logo = EscposImage::load("C:\Users\hp\Documents\GitHub\ProyectoExtintores\public\material\img\imprimir.gif", false);
                $impresora->bitImage($logo2);
                $impresora->setTextSize(3, 3);
                $impresora->text("A & S\n");
                $impresora->setTextSize(2, 2);
                $impresora->text("ASESORIAS Y SUMINISTROS DEL SUR\n");
                $impresora->setTextSize(1, 1);
                $impresora->text("Carrera 5 #3-153 sur interior 3 EDS Neiva de gas");
                $impresora->text("Fecha de Ingreso: ");
                $impresora->text($ingreso->fecha_recepcion . "\n");
                $impresora->feed(2);
                $impresora->text("Cliente: ");
                $impresora->text(($ingreso->encargado->nombre_encargado) . "\n");
                $impresora->text("Numero de referencia: ");
                $impresora->text($ingreso->id . "\n");
                $impresora->feed(1);
 */
              /*   foreach( $data as $item){
                    $impresora->setJustification(Printer::JUSTIFY_LEFT);
                    $impresora->text("Numero de Extintores:  ");
                    $impresora->text($item->numero_extintor. "\n");
                    $impresora->text("Actividad           :  ");
                    $impresora->text($item->nombre_actividad. "\n");
                    $impresora->text("Unidad de medida    :  ");
                    $impresora->text($item->unidad_medida. "\n");
                    $impresora->text("Cantidad de Media   :  ");
                    $impresora->text($item->cantidad_medida.  "\n");
                    $impresora->text("------------------------------------------------");
                };
                $impresora->setJustification(Printer::JUSTIFY_CENTER);
                $impresora->text("Colaborador: ");
                $impresora->text(($ingreso->usuario->nombre . " " . $ingreso->usuario->apellido) . "\n");
                $impresora->feed(3);
                $impresora->cut();
                $impresora->close(); */
/*  *//*

                return redirect('listIngreso');
            } else {
                return back();
            } */

            if ($actingreso) {

                $ingreso = Ingreso::where('numero_referencia', $id_referencia)
                ->with('Usuario', 'Encargado')
                ->first();

                $data = $this->obtenerListadoIngreso($id_referencia);

                $generarCodigo = Ingreso::where('numero_referencia', $id_referencia)
                ->with('Usuario', 'Encargado')
                ->first();
                $pdf = PDF::loadView('pdf.pdf',['ingreso'=>$ingreso],['data' => $data]);
                return $pdf->stream();
                //return redirect('listIngreso');
            }




            //return view('pdf.pdf',  compact('ingreso', 'data'));
    }

    private function obtenerListadoIngreso($idIngreso)
    {
        return  ListadoIngreso::select('listado_ingreso.id', 'listado_ingreso.unidad_medida_id', 'listado_ingreso.created_at', 'listado_ingreso.numero_extintor', 'actividades.nombre_actividad','unidades_medida.*')
            ->where('ingreso_id', $idIngreso)
            ->join('actividades', 'listado_ingreso.actividad_id', '=', 'actividades.id')
            ->join('unidades_medida', 'listado_ingreso.unidad_medida_id', '=', 'unidades_medida.id')
            ->get();
    }
    public function getIngreso($id_vendedor)
    {
        /** Validamos si encuentra un ingreso con el id del usuario y en estado de recibido si exite que nos lo muestre
         * de lo contrario que nos cree un nuevo ingreso
         */

        $ingreso = DB::table('ingresos')->where('estado', 'recibido')->where('usuario_id', $id_vendedor)->first();
        if ($ingreso)
            return $ingreso;
        else
            $ingreso = new Ingreso();
        $ingreso->fecha_recepcion = now();
        $ingreso->usuario_id = $id_vendedor;
        $ingreso->numero_referencia = $ingreso->id;
        $ingreso->estado = 'recibido';
        $ingreso->save();

        return $ingreso;
    }
    public function listadoPorIngreso($idIngreso)
    {
        $data = Ingreso::where('id', $idIngreso)->with(
            'Listado_Ingreso',
            'Listado_Ingreso.UnidadMedida.SubCategoria.Categoria',
            'Listado_Ingreso.ActividadIngreso',
            'Usuario',
            'Encargado'
        )->get();
        $var = json_encode($data);
        return $var['listado_ingreso'];
        //return view('pages.ingreso.listadoPorIngreso', compact('var'));
    }
    public function index($id)
    {
        /** Hacemos llamado del metodo anterior llevando el respectivo ingreso */
        $crearId = $this->getIngreso($id);
        return view('pages.ingreso.index', compact('crearId'));
    }
    public function listadoIngreso($id)
    {
        $actingreso = Ingreso::where('numero_referencia', $id)->first();
        $total = $actingreso->numero_total_extintor;
        return view('pages.listadoIngreso.listadoIngreso', compact('id', 'total'));
    }
    public function getEstadoIngreso()
    {
        /** Buscamos todos los ingresos que se encuentre con los estados diferentes a recibido */

        $data = Ingreso::select('id', 'fecha_recepcion', 'fecha_entrega', 'encargado_id', 'usuario_id', 'numero_referencia', 'numero_total_extintor', 'estado')
            ->where('estado', '=', 'Produccion')->get();
        return view('pages.ingreso.verIngreso', compact('data'));
    }

    public function update(Request $request, $id)
    {

        /** Creamos este metodo para hacer uso de el en varias situaciones */
        if($request->numero_total_extintor <= 0)
            return back()->with('error',"Numero de extintores no puede ser 0");
        $ingreso = Ingreso::where('id', $id)->first();
        $numeroExtintores = $request->numero_total_extintor;
        $id = $ingreso->id;
        if ($ingreso) {
            $ingreso->fecha_entrega = $request->input('fecha_entrega');
            $ingreso->encargado_id  = $request->input('encargado_id');
            $ingreso->numero_referencia = $ingreso->id;
            $ingreso->numero_total_extintor = $request->input('numero_total_extintor');
            $total = $request->input('numero_total_extintor');
            $ingreso->estado = 'Produccion';
            /**
             * Hacemos llamado al metodo donde nos indica la etiqueta anterior
             * y hace la suma de los extintores que estamos ingresando para generar las etiquetas
             * pertinentes
             */
            $numeroEtiqueta = NumeroTiquete::select('id', 'numero_tiquete')->get()->last();
            // return [
            //     'etiquetaDisponible' => $numeroEtiqueta->numero_tiquete,
            //     'numeroExtintoresIngreso' => $numeroExtintores,
            //     'nuevaEtiqueta' => (($numeroEtiqueta->numero_tiquete) + $numeroExtintores)
            // ];

            // Guardamos en base de datos
            $ingreso->save();
            return redirect('ingresoL/' . $id);
        } else {
            return redirect('listIngreso')->with('error', 'No se actualizo  el ingreso');
        }
    }
    public function cambioEstado($id)
    {

        try {
            $numeroEtiqueta = NumeroTiquete::all()->last();

            $actingreso = Ingreso::where('id', $id)->first();
            for ($i = 1; $i <= $actingreso->numero_total_extintor; $i++) {
                $nuevaEtiqueta = new NumeroTiquete();
                $nuevaEtiqueta->numero_tiquete = $numeroEtiqueta->numero_tiquete + $i;
                $nuevaEtiqueta->ingreso_id = $actingreso->id;
                $nuevaEtiqueta->save();
            }
            if ($actingreso) {
                $actingreso->estado = 'Produccion';
                $actingreso->save();
                return redirect('listIngreso');
            } else {
                return back();
            }
        } catch (\Throwable $th) {
            return back();
        }
    }
    public function actualizarI(Request $request, $id)
    {
        try {
            $ingreso = Ingreso::where('id', $id)->first();
            $id = $ingreso->id;
            if ($ingreso) {
                $ingreso->fecha_entrega = $request->input('fecha_entrega');
                $ingreso->encargado_id  = $request->input('encargado_id');
                $ingreso->numero_referencia = $ingreso->id;
                $ingreso->numero_total_extintor = $ingreso->numero_total_extintor;
                $ingreso->estado = $ingreso->estado;
                // Guardamos en base de datos
                $ingreso->save();

                return redirect('listIngreso');
                //return view('pages.listadoIngreso.listadoIngreso',compact('id','total'));
                //return redirect('listadoIngreso');
            }
        } catch (\Throwable $th) {
            return redirect('listIngreso')->with('error', 'No se actualizo  el ingreso');
        }
    }
    public function updateTotalExtintor(Request $request, $id)
    {
        /** Creamos este metodo para hacer uso de el en varias situaciones */
        try {
            $ingreso = Ingreso::where('id', $id)->first();
            $id = $ingreso->id;
            if ($ingreso) {
                $ingreso->fecha_entrega = $ingreso->fecha_entrega;
                $ingreso->encargado_id  = $ingreso->encargado_id;
                $ingreso->numero_referencia = $ingreso->id;
                $ingreso->numero_total_extintor = $request->numero_total_extintor;
                $ingreso->estado = 'Produccion';
                // Guardamos en base de datos
                $ingreso->save();
                return back();
            }
        } catch (\Throwable $th) {
            return redirect('listIngreso')->with('error', 'No se actualizo  el ingreso');
        }
    }
    public function imprimirTiquete($id)
    {
        $generarCodigo = NumeroTiquete::select('*')->where('ingreso_id', $id)->get();
        // return $generarCodigo;
        return view('barCode', compact('generarCodigo'));
    }
}
