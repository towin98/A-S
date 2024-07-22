<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
/** Los nombres con _ son relacion con tablas que ya han tenido el mismo nomobre es para poder hacer diferecia entre ellos  */
{
    protected $table = 'ingresos';
    protected $fillable = ['fecha_recepcion', 'fecha_entrega',  'encargado_id', 'usuario_id', 'numero_referencia','numero_total_extintor', 'estado'];

    static $rules = [
        'fecha_recepcion'           => 'required|date_format:Y-m-d',
        'fecha_entrega'             => 'required|date_format:Y-m-d',
        'encargado_id'              => 'required|numeric',
        'usuario_id'                => 'nullable|numeric',
        'numero_referencia'         => 'required|numeric',
        'numero_total_extintor'     => 'required|numeric|min:1',
        'estado'                    => 'required|string'
    ];

    static $messagesRules = [
        'fecha_recepcion.required'      => 'La fecha de ingreso es requerida',
        'fecha_recepcion.date_format'   => 'La fecha de ingreso debe cumplir el formato Y-m-d',
        'fecha_entrega.required'        => 'La fecha de entrega es requerida',
        'fecha_recepcion.date_format'   => 'La fecha de entrega debe cumplir el formato Y-m-d',
        'encargado_id.required'         => 'El cliente es requerido.',
        'encargado_id.numeric'          => 'El cliente debe ser númerico.',
        'numero_referencia.required'    => 'El número de referencia es requerido.',
        'numero_referencia.numeric'     => 'El número de referencia debe ser númerico.',
        'numero_total_extintor.required'=> 'El número total de extintores es requerido.',
        'numero_total_extintor.min'     => 'El número total de extintores debe ser mayor a 0.',
        'numero_total_extintor.numeric' => 'El número total de extintores debe ser númerico.',
        'estado.required'               => 'El estado es requerido.'
    ];

    #Relaciones con demas tablas
    public function Usuario()
    {
        //RELACION CON USURS
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }
    public function Encargado()
    {
        //RELACION CON ENCARGADO
        return $this->belongsTo(Encargado::class, 'encargado_id', 'id');
    }
    public function Listado_Ingreso()
    {
        //RELACION CON LISTADO DE INGRESO
        return $this->hasMany(ListadoIngreso::class, 'ingreso_id', 'id');
    }
    public function Ingreso_Recarga()
    {
        //RELACION CON RECARGA
        return $this->hasMany(Recarga::class, 'ingreso_recarga_id', 'id');
    }

}
