<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portatiles extends Model
{
    protected $table = 'hocol_extintor_portatil';
    protected $fillable = ['nombreParteExtintor'];
    #Relacion con las demas tablas

    public function listadoPortatil()
    {
        return $this->belongsTo(listadoPortatil::class, 'id', 'id_extintores_portatil');
    }
}
