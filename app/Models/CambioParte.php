<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CambioParte extends Model
{
    protected $table = 'cambio_parte_extintor';
    protected $fillable = ['nombre_parte_cambio', 'referencia'];
    #Llave foraneas
    public function CambioParteRecarga()
    {
        //RELACION CON CAMBIO DE PARTE DE EXTINTOR
        return $this->belongsTo(CambioParte::class,'cambio_parte_id','id');
    }
}
