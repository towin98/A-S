<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    protected $table = 'pruebas';
    protected $fillable = ['nombre_prueba', 'abreviacion_prueba'];
    public function PruebaRecarga()
    {
        //RELACION CON PRUEBA
        return $this->belongsTo(Prueba::class, 'prueba_id', 'id');
    }
}
