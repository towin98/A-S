<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class GeneradorController extends Controller
{

    public function imprimir()
    {
       //return view('pdf/ejemplo');
     $pdf = PDF::loadView('pdf/ejemplo');
        return $pdf->download('ejemplo.pdf');


    }
}
