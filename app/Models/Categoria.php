<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $fillable = ['nombre_categoria', 'estado'];

    #Relacion con las demas tablas
    public function subCategoria()
    {
        return $this->hasMany(SubCategoria::class, 'categoria_id', 'id');
    }
}
