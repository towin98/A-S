<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    protected $table = 'unidades_medida';
    protected $fillable = ['unidad_medida', 'cantidad_medida', 'sub_categoria_id'];

    #Llave foraneas
    public function SubCategoria()
    {
        //Relacion con SUBCATEGORIA
        return $this->belongsTo(SubCategoria::class, 'sub_categoria_id', 'id');
    }
    public function ListadoUnidadMedida()
    {
        //Relacion con LISTADO INGRESO
        return $this->hasMany(ListadoIngreso::class, 'unidad_medida_id', 'id');
    }
    public function UnidadRecarga()
    {
        //Relacion con LISTADO INGRESO
        return $this->hasMany(Recarga::class, 'capacidad_id', 'id');
    }
}
