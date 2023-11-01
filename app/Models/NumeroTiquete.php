<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class NumeroTiquete extends Model
{
    protected $table = 'numero_tiquetes';
    protected $fillable = ['id', 'numero_tiquete', 'ingreso_id', 'recarga_id', 'estado'];

}
