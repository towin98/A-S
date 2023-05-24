<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListadoPortatil extends Model
{
    protected $table = 'listado_portatil';
    #Relacion con las demas tablas

    public function portatil()
    {
        return $this->hasMany(Portatiles::class, 'id', 'id_extintores_portatil');
    }
}
