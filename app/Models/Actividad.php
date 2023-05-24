<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';
    protected $fillable = ['nombre_actividad', 'abreviacion_actividad'];
    #Llaves foraneas
    public function ActividadRecarga()
    {
        //RELACION CON ACTIVIDAD
        return $this->belongsTo(Actividad::class, 'activida_recarga_id', 'id');
    }
    public function IngresoActividad()
    {
        //RELACION CON LA TABLA INGRESO
        return $this->belongsTo(Ingreso::class, 'actividad_id', 'id');
    }
    public  function ListadoIngresoActividad()
    {
        return $this->belongsTo(ListadoIngreso::class, 'actividad_id', 'id');
    }
}
