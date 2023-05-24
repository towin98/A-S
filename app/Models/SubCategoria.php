<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model
{
    protected $table ='subcategorias';
    protected $fillable = ['id','nombre_subCategoria','categoria_id','abreviacion'];

    #Relacion con las demas tablas
    public function Categoria()
    {
        return $this->belongsTo(Categoria::class,'categoria_id','id');
    }
    public function UnidadMedida()
    {
         return $this->hasMany(UnidadMedida::class, 'sub_categoria_id', 'id');
    }
    public function SubListadoIngreso()
    {
        return $this->belongsTo(ListadoIngreso::class, 'sub_categoria_id', 'id');
    }
}
