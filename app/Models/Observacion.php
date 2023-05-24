<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    protected $table = 'observaciones';
    protected $fillable = ['observacion', 'numero_etiqueta'];
}
