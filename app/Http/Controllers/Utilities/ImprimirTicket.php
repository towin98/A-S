<?php

namespace App\Http\Controllers\Utilities;

use App\Models\Ingreso;
use Mike42\Escpos\Printer;
use Mike42\Escpos\compaj;
use Mike42\Escpos\EscposImage;

trait ImprimirTicket{

    public function ticket($id_referencia){

        $ingreso = Ingreso::where('numero_referencia', $id_referencia)
        ->with('Usuario','Encargado')
        ->first();


        $nombreImpresora = ("SAT 22TUS");
        $connector = new WindowsPrintConnector($nombreImpresora);
        $impresora = new Printer($connector);



        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $logo = EscposImage::load("C:\Users\hp\Documents\GitHub\ProyectoExtintores\public\material\img\imprimir.gif", false);
        $logo2 =  EscposImage::load("C:\Users\hp\Documents\GitHub\ProyectoExtintores\public\barra.png", false);
        $impresora->bitImage($logo);
        $impresora->setEmphasis(true);
        $impresora->setTextSize(3, 3);
        $impresora->text("A & S\n");
        $impresora->setTextSize(2, 2);
        $impresora->text("ASESORIAS Y SUMINISTROS DEL SUR\n");
        $impresora->setTextSize(1, 1);
        $impresora->text("Fecha de Ingreso: ");
        $impresora->text($ingreso->fecha_recepcion ."\n");
        $impresora->text("Cliente: ");
        $impresora->text(($ingreso->encargado->nombre_encargado) . "\n");
        $impresora->text("Numero de referencia: ");
        $impresora->text($ingreso->id . "\n");
        $impresora->text("Colaborador: ");
        $impresora->text(($ingreso->usuario->nombre ." ". $ingreso->usuario->apellido) . "\n");
        $impresora->text("Carrera 5 #3-153 sur interior 3 EDS Neiva de gas");
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->bitImage($logo);
        $impresora->feed(3);
        $impresora->cut();
        $impresora->close();

        return redirect()->back()->with("mensaje", "Ticket impreso");

        }
}
