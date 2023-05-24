<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class listadoRecarga extends Model
{
    protected $table = 'listado_recarga';
    //Relacion con la tabla de recarga
    function RecargaListado()
    {
        return $this->belongsTo(Recarga::class, 'recarga_id', 'id');
    }
    function CambioPartesRecarga()
    {
        return $this->hasMany(CambioParte::class, 'cambio_parte_id', 'id');
    }
}
