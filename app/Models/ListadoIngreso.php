<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListadoIngreso extends Model
{
    protected $table = 'listado_ingreso';
    protected $fillable = ['ingreso_id', 'ingreso_id', 'unidad_medida_id', 'numero_extintor', 'actividad_id'];

    static $rules = [
        'ingreso_id'                => 'required|numeric',
        'unidad_medida_id'          => 'required|numeric',
        'actividad_id'              => 'required|numeric',
        'numero_extintor'           => 'required|numeric|min:1',
        'estado'                    => 'required|numeric'
    ];

    static $messagesRules = [
        'ingreso_id.required'           => 'El id de ingreso es requerido.',
        'ingreso_id.numeric'            => 'El id de ingreso debe ser númerico.',
        'unidad_medida_id.required'     => 'La Unidad de medida es requerido.',
        'unidad_medida_id.numeric'      => 'La Unidad de medida debe ser númerico.',
        'actividad_id.required'         => 'La Actividad es requerido.',
        'actividad_id.numeric'          => 'La Actividad debe ser númerico.',
        'numero_extintor.required'      => 'El número de extintores es requerido.',
        'numero_extintor.min'           => 'El número de extintores debe ser mayor a 0.',
        'numero_extintor.numeric'       => 'El número de extintores debe ser númerico.',
        'estado.required'               => 'El estado es requerido.'
    ];

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
