<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class listadoPrueba extends Model
{
    protected $table = 'listado_prueba';
    //Relacion con la tabla de recarga
    function RecargaListado()
    {
        return $this->belongsTo(Recarga::class, 'recarga_id', 'id');
    }
    function CambioPartesRecarga()
    {
        return $this->hasMany(Fuga::class, 'prueba_id', 'id');
    }
}
