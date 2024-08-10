<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

#Buscar informacion del extintor
Route::get('info', 'Info\InformacionController@index');
Route::post('info', 'Info\InformacionController@search');

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::get('table-list', function () {
        return view('pages.table_list');
    })->name('table');

    #Registro colaborador
    Route::get('registro', 'UserController@nuevoRegistro');
    Route::post('registro', 'UserController@guardarRegistro');

    #Categorias
    Route::get('categoria', 'Categoria\CategoriaController@index')->name('categoria');
    Route::post('categoria', 'Categoria\CategoriaController@store');
    Route::put('categoria/{id}', 'Categoria\CategoriaController@update')->where('id', '[0-9]+');
    Route::delete('categoria/{id}', 'Categoria\CategoriaController@destroy')->where('id', '[0-9]+');

    #SubCategoria
    Route::get('subCategoria', 'SubCategoria\SubCategoriaController@index')->name('subCategoria');
    Route::post('subCategoria', 'SubCategoria\SubCategoriaController@store');
    Route::put('subCategoria/{id}', 'SubCategoria\SubCategoriaController@update')->where('id', '[0-9]+');
    Route::delete('subCategoria/{id}', 'SubCategoria\SubCategoriaController@destroy')->where('id', '[0-9]+');

    #Unidad de medidad
    Route::get('unidad', 'Unidad\UnidadController@index')->name('unidad');
    Route::get('unidad/{id}', 'Unidad\UnidadController@edit')->where('id', '[0-9]+');
    Route::post('unidad', 'Unidad\UnidadController@store');
    Route::put('unidad/{id}', 'Unidad\UnidadController@update')->where('id', '[0-9]+');
    Route::delete('unidad/{id}', 'Unidad\UnidadController@destroy')->where('id', '[0-9]+');

    #Empresa
    Route::get('empresa', 'Empresa\EmpresaController@index')->name('empresa');
    Route::post('empresa', 'Empresa\EmpresaController@store');
    Route::put('empresa/{id}', 'Empresa\EmpresaController@update')->where('id', '[0-9]+');
    Route::delete('empresa/{id}', 'Empresa\EmpresaController@destroy')->where('id', '[0-9]+');

    #Encargado
    Route::post('buscarCliente', 'Encargado\EncargadoController@getClient');
    Route::get('encargado', 'Encargado\EncargadoController@index')->name('encargado');
    Route::post('encargado', 'Encargado\EncargadoController@store');
    Route::put('encargado/{id}', 'Encargado\EncargadoController@update')->where('id', '[0-9]+');
    Route::delete('encargado/{id}', 'Encargado\EncargadoController@destroy')->where('id', '[0-9]+');

    #Prueba
    Route::get('prueba', 'Prueba\PruebaController@index')->name('prueba');
    Route::post('prueba', 'Prueba\PruebaController@store');
    Route::put('prueba/{id}', 'Prueba\PruebaController@update')->where('id', '[0-9]+');
    Route::delete('prueba/{id}', 'Prueba\PruebaController@destroy')->where('id', '[0-9]+');

    #Fufa
    Route::get('fuga', 'Fuga\FugaController@index')->name('fuga');
    Route::post('fuga', 'Fuga\FugaController@store');
    Route::put('fuga/{id}', 'Fuga\FugaController@update')->where('id', '[0-9]+');
    Route::delete('fuga/{id}', 'Fuga\FugaController@destroy')->where('id', '[0-9]+');

    #CambioParte
    Route::get('cambio', 'CambioParte\CambioPartesController@index')->name('cambio');
    Route::post('cambio', 'CambioParte\CambioPartesController@store');
    Route::put('cambio/{id}', 'CambioParte\CambioPartesController@update')->where('id', '[0-9]+');
    Route::delete('cambio/{id}', 'CambioParte\CambioPartesController@destroy')->where('id', '[0-9]+');

    #Actividad
    Route::get('actividad', 'Actividad\ActividadesController@index')->name('actividad');
    Route::post('actividad', 'Actividad\ActividadesController@store');
    Route::put('actividad/{id}', 'Actividad\ActividadesController@update')->where('id', '[0-9]+');
    Route::delete('actividad/{id}', 'Actividad\ActividadesController@destroy')->where('id', '[0-9]+');

    #Usuario
    Route::put('usuario/{id}', 'UserController@update')->where('id', '[0-9]+');
    Route::delete('usuario/{id}', 'UserController@destroy')->where('id', '[0-9]+');

    #Ingreso
    Route::get('ingreso/{id}', 'Ingreso\IngresoController@index')->name('ingreso');
    Route::put('ingresoL/{id}', 'Ingreso\IngresoController@update')->where('id', '[0-9]+');
    Route::get('listIngreso', 'Ingreso\IngresoController@getEstadoIngreso')->name('listIngreso');
    Route::put('ingreso/{id}', 'Ingreso\IngresoController@actualizarI')->where('id', '[0-9]+');
    Route::put('totalExt/{id}', 'Ingreso\IngresoController@updateTotalExtintor')->where('id', '[0-9]+');
    Route::get('ingresoL/{id}', 'Ingreso\IngresoController@listadoIngreso')->where('id', '[0-9]+');
    Route::get('ingresoact/{id}', 'Ingreso\IngresoController@cambioEstado')->where('id', '[0-9]+');
    Route::get('imprimirPdf/{id}', 'Ingreso\IngresoController@imprimirTiquete')->where('id', '[0-9]+');
    Route::get('ticket/{idReferencia}', 'Ingreso\IngresoController@ticket')->where('idReferencia', '[0-9]+');
    Route::get('listarRegistroIngreso/{id}', 'Ingreso\IngresoController@listadoPorIngreso')->where('id', '[0-9]+');

    #Reportes
    Route::get('reporte/extintor', 'Reportes\ReporteController@vistaReporteExtintor')->name('viewReporteExtintor');
    Route::get('reporte/extintor-etiqueta/{search_numero_etiqueta}', 'Reportes\ReporteController@reporteEtiquetaExtintor');
    Route::get('reporte/cliente-extintor', 'Reportes\ReporteController@vistaReporteClienteExtintor')->name('viewReporteClienteExtintor');
    Route::post('reporte/cliente-ordenes-servicio', 'Reportes\ReporteController@reporteClienteOrdenesServicio');
    Route::get('reporte/orden-servicio', 'Reportes\ReporteController@vistaReporteOrdenServicio')->name('viewReporteOrdenServicio');
    Route::post('reporte/orden', 'Reportes\ReporteController@reporteOrden');

    #ListadoIngreso
    Route::get('listadoIngreso/{id}', 'ListadoIngreso\ListadoIngresoController@index')->name('listadoIngreso');
    Route::get('verListado', 'ListadoIngreso\ListadoIngresoController@verListado');
    Route::get('listIngreso/{id}', 'ListadoIngreso\ListadoIngresoController@ListadoIngreso')->where('id', '[0-9]+');

    Route::post('listadoIngreso', 'ListadoIngreso\ListadoIngresoController@store');
    Route::put('listadoIngreso/{id}', 'ListadoIngreso\ListadoIngresoController@update')->where('id', '[0-9]+');
    Route::delete('listadoIngreso/{id}', 'ListadoIngreso\ListadoIngresoController@destroy')->where('id', '[0-9]+');
    Route::delete('ingresoListado/{id}', 'ListadoIngreso\ListadoIngresoController@eliminarIngresoListado')->where('id', '[0-9]+');

    #Ruta para combo dinamico Subcategoria
    Route::get('ingresoL/comboSubcategoria/{id}', 'ListadoIngreso\ListadoIngresoController@byCategoria');
    #Ruta para combo dinamico Unidadmedida
    Route::get('ingresoL/comboUnidadMedida/{id}', 'ListadoIngreso\ListadoIngresoController@bySubcategoria');
    #Ruta para la categoria en recarga
    Route::get('recarga/getUnidad/{id}', 'Recarga\RecargaController@getUnidad');

    #Recargas
    Route::get('recarga', 'Recarga\RecargaController@index')->name('recarga');
    Route::get('recarga/{id}', 'Recarga\RecargaController@setRecargaListado');
    Route::post('recarga', 'Recarga\RecargaController@store');
    Route::put('recarga/{id}', 'Recarga\RecargaController@update')->where('id', '[0-9]+');
    Route::delete('recarga/{id}', 'Recarga\RecargaController@destroy')->where('id', '[0-9]+');
    Route::delete('recarga/eliminar-extintor-orden/{id}', 'Recarga\RecargaController@eliminarExtintorOrden')->where('id', '[0-9]+');

    #Listado recarga
    Route::get('infoRecarga/{id}', 'Recarga\RecargaController@informacionListadoRecarga')->where('id', '[0-9]+');
    #Observaciones
    Route::get('observacion', 'Observaciones\ObservacionEtiquetaController@index')->name('observacion');
    Route::post('observacion', 'Observaciones\ObservacionEtiquetaController@store');
    #Hocol
    Route::get('verHocol', 'Hocol\HocolController@verHocol')->name('ingreso-hocol');
    Route::get('verMas/{id}', 'Hocol\HocolController@getMore')->where('id', '[0-9]+');
    Route::get('hocol', 'Hocol\HocolController@index')->name('hocol');
    Route::post('hocol', 'Hocol\HocolController@store');
    Route::get('export', 'Hocol\HocolController@export')->name('export.hocol');
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

//PDF
Route::name('print')->get('/imprimir', 'GeneradorController@imprimir');

Route::get('export/{id}', 'ListadoIngreso\ListadoIngresoController@exportarListadoIngreso')->where('id', '[0-9]+');
