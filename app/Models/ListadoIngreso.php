<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListadoIngreso extends Model
{
    protected $table = 'listado_ingreso';
    protected $fillable = ['ingreso_id', 'ingreso_id', 'unidad_medida_id', 'numero_extintor', 'actividad_id'];

    #Relaciones con demas tablas
    public function UnidadMedida()
    {
        //RELACION CON UNIDAD MEDIDA
        return $this->belongsTo(UnidadMedida::class, 'unidad_medida_id', 'id');
    }

    public function IngresoListado()
    {
        //RELACION CON INGRESO
        return $this->belongsTo(Ingreso::class, 'ingreso_id', 'id');
    }
    public function ActividadIngreso()
    {
        //RELACION CON LA TABLA ACTIVIDADES
        return $this->hasMany(Actividad::class, 'id');
    }
}
