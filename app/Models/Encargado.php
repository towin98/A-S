<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encargado extends Model
{
    protected $table = 'encargados';
    protected $fillable = ['nombre_encargado', 'numero_celular', 'email', 'direccion', 'numero_serial'];


    public function IngresoEncargado()
    {
        return $this->hasMany(Ingreso::class, 'encargado_id', 'id');
    }
}
