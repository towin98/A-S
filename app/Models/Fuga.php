<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fuga extends Model
{
    protected $table = 'fugas';
    protected $fillable = ['nombre_fuga', 'abreviacion_fuga'];
}
