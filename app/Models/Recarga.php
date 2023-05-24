<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Recarga extends Model
{
    protected $table = 'recargas';
    protected $fillable = ['nro_tiquete_anterior', 'nro_tiquete_nuevo', 'nro_extintor', 'agente', 'ingreso_recarga_id', 'usuario_recarga_id', 'activida_recarga_id', 'cambio_parte_id', 'prueba_id', 'fuga_id', 'observacion'];

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
        return $this->hasMany(Actividad::class, 'id');
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
        return $this->hasMany(Fuga::class, 'id');
    }
    public function UnidadMedida()
    {
        //RELACION CON FUGA
        return $this->belongsTo(UnidadMedida::class, 'capacidad_id', 'id');
    }
}
