<?php

use App\Models\{Carretilla, Ingreso, Observacion, Portatiles};

function Categoria()
{
    return App\Models\Categoria::select('id', 'nombre_categoria', 'estado')->get();
}
function CategoriaActiva()
{
    return App\Models\Categoria::select('id', 'nombre_categoria', 'estado')->where('estado', '=', 1)->get();
}
function SubCategoria()
{
    return App\Models\SubCategoria::select('id', 'nombre_subCategoria', 'categoria_id', 'abreviacion', 'estado')->get();
}
function SubCategoriaActiva()
{
    return App\Models\SubCategoria::select(
        'subcategorias.id',
        'subcategorias.nombre_subCategoria',
        'subcategorias.categoria_id',
        'subcategorias.abreviacion',
        'subcategorias.estado',
        'categorias.nombre_categoria'
    )
        ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
        ->where('subcategorias.estado', '=', 1)->get();
}

function Unidad()
{
    return App\Models\UnidadMedida::select(
        'unidades_medida.id',
        'unidades_medida.unidad_medida',
        'unidades_medida.cantidad_medida',
        'subcategorias.nombre_subCategoria',
        'categorias.nombre_categoria'
    )
        ->join('subcategorias', 'unidades_medida.sub_categoria_id', '=', 'subcategorias.id')
        ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
        ->where('unidades_medida.estado', '=', 1)->get();
}

function Encargado()
{
    return App\Models\Encargado::select('id', 'nombre_encargado', 'numero_celular', 'email', 'direccion', 'numero_serial')->get();
}
function Prueba()
{
    return App\Models\Prueba::select('id', 'nombre_prueba', 'abreviacion_prueba')->get();
}
function Fuga()
{
    return App\Models\Fuga::select('id', 'nombre_fuga', 'abreviacion_fuga')->get();
}
function cambioParte()
{
    return App\Models\CambioParte::select('id', 'nombre_parte_cambio', 'referencia')->get();
}
function Actividad()
{
    return App\Models\Actividad::select('id', 'nombre_actividad', 'abreviacion_actividad')->get();
}
function Usuario()
{
    return App\User::select('id', 'nombre', 'apellido', 'cargo', 'email')->get();
}
function ListadoIngreso()
{
    $unidad = Ingreso::all()->where('estado', '=', 'Proceso');
    return $unidad;
}
function Observaciones()
{
    return Observacion::all();
}
function ExtintoresPortatiles()
{
    return Portatiles::all();
}
function ExtintoresCarretilla()
{
    return Carretilla::all();
}
