<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListadoCarretilla extends Model
{
    protected $table = 'listado_carretilla';

    #Relacion con las demas tablas

    public function carretilla()
    {
        return $this->hasMany(Carretilla::class, 'id', 'id_extintores_carretilla');
    }
}
