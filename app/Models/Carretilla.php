<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carretilla extends Model
{
    protected $table = 'hocol_extintores_carretilla';
    protected $fillable = ['nombreParteExtintorCarretilla'];
    #Relacion con las demas tablas

    public function listadoCarretilla()
    {
        return $this->belongsTo(listadoCarretilla::class, 'id', 'id_extintores_carretilla');
    }
}
