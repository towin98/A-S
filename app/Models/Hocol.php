<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Hocol extends Model
{
    protected $table = 'registro_hocol';

    public function colaborador()
    {
        //RELACION CON COLABORADOR
        return $this->belongsTo(User::class, 'id_colaborador', 'id');
    }
    public function capacidadExtintor()
    {
        //RELACION CON CAPACIDAD EXTINTOR
        return $this->belongsTo(UnidadMedida::class, 'id_capacidad', 'id');
    }
    public function listadoPortatil()
    {
        //RELACION CON CAPACIDAD EXTINTOR
        return $this->hasMany(listadoPortatil::class, 'id_registro_hocol', 'id');
    }
    public function listadoCarretilla()
    {
        //RELACION CON CAPACIDAD EXTINTOR
        return $this->hasMany(listadoCarretilla::class, 'id_registro_hocol', 'id');
    }
}
