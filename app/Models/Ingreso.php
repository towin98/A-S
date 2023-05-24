<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
/** Los nombres con _ son relacion con tablas que ya han tenido el mismo nomobre es para poder hacer diferecia entre ellos  */
{
    protected $table = 'ingresos';
    protected $fillable = ['fecha_recepcion', 'fecha_entrega',  'encargado_id', 'usuario_id', 'numero_referencia','numero_total_extintor', 'estado'];

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
