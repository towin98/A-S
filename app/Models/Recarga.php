<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Recarga extends Model
{
    protected $table = 'recargas';
    protected $fillable = [
        'nro_tiquete_anterior',
        'nro_tiquete_nuevo',
        'nro_extintor',
        'capacidad_id',
        'agente',
        'ingreso_recarga_id',
        'usuario_recarga_id',
        'activida_recarga_id',
        'cambio_parte_id',
        'prueba_id',
        'fuga_id',
        'observacion',
        'ingreso_actividad',
        'nuevo_extintor',
        'fecha_hidrostatica',
        'n_interno_cliente',
        'n_extintor',
        'estado'
    ];

    static $rules = [
        'nro_tiquete_anterior'    => 'nullable|numeric',
        'nro_tiquete_nuevo'       => 'required|numeric',
        'nro_extintor'            => 'required|numeric',
        'capacidad_id'            => 'required|numeric',
        'agente'                  => 'required|string|max:255',
        'usuario_recarga_id'      => 'required|numeric',
        'ingreso_recarga_id'      => 'required|numeric',
        'activida_recarga_id'     => 'required|numeric',
    ];

    static $messagesRules = [
        'nro_tiquete_anterior.numeric'      => 'El tiquete anterior debe ser númerico.',
        'nro_tiquete_nuevo.required'        => 'El tiquete nuevo es requerido.',
        'nro_tiquete_nuevo.numeric'         => 'El tiquete nuevo debe ser númerico.',
        'nro_extintor.required'             => 'El número de extintor es requerido.',
        'nro_extintor.numeric'              => 'El número de extintor debe ser númerico.',
        'capacidad_id.required'             => 'La unidad de medida es requerida.',
        'capacidad_id.numeric'              => 'La unidad de medida debe ser númerica.',
        'agente.required'                   => 'El Agente es requerido.',
        'agente.max'                        => 'El Agente solo puede contener 255 caracteres máximo.',
        'usuario_recarga_id.required'       => 'El usuario que recargo es requerido.',
        'usuario_recarga_id.numeric'        => 'El usuario que recargo debe ser númerico.',
        'ingreso_recarga_id.required'       => 'El No de referencia es requerido.',
        'ingreso_recarga_id.numeric'        => 'El No de referencia debe ser númerico.',
        'activida_recarga_id.required'      => 'El tipo actividad de recarga es requerido.',
        'activida_recarga_id.numeric'       => 'El tipo actividad de recarga debe ser númerico.'
    ];

    #Llaves foraneas
    public function RecargaUsuario()
    {
        //RELACION CON USERS
        return $this->belongsTo(User::class, 'usuario_recarga_id', 'id');
    }
    public function RecargaIngreso()
    {
        //RELACION CON INGRESO
        return $this->belongsTo(Ingreso::class, 'ingreso_recarga_id', 'id');
    }
    public function RecargaActividad()
    {
        //RELACION CON ACTIVIDAD
        return $this->hasMany(Actividad::class, 'id', 'activida_recarga_id');
    }
    public function RecargaCambioParte()
    {
        //RELACION CON CAMBIO DE PARTE DE EXTINTOR
        return $this->hasMany(CambioParte::class, 'cambio_parte_id', 'id');
    }
    public function RecargaPrueba()
    {
        //RELACION CON PRUEBA
        return $this->hasMany(Prueba::class, 'prueba_id', 'id');
    }
    public function RecargaFuga()
    {
        //RELACION CON FUGA
        return $this->hasMany(Fuga::class, 'id', 'fuga_id');
    }
    public function UnidadMedida()
    {
        //RELACION CON FUGA
        return $this->belongsTo(UnidadMedida::class, 'capacidad_id', 'id');
    }
}
