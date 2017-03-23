<?php

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
//Fecha: 08/02/2016
//Creando las rutas de las tablas parametricas que se van a utilizar en la correspondencia interna
//esto es una prueba
//Route::auth();
Route::resource('sucursal', 'SucursalController', ['only' => ['index', 'show']]);
Route::resource('tipodestinatario', 'TipoDestinatarioController', ['only' => ['index', 'show']]);
Route::resource('tipocorrespondencia', 'TipoCorrespondenciaController', ['only' => ['index', 'show']]);
Route::resource('usuario', 'UsuarioController', ['only' => ['index', 'show']]);
Route::resource('copia', 'CopiaController', ['only' => ['index', 'show']]);
Route::resource('gerencia', 'GerenciaController', ['only' => ['index', 'show']]);
Route::resource('empleado', 'EmpleadoController', ['only' => ['index', 'show']]);
Route::resource('trabajo', 'TipoTrabajoController', ['only' => ['index', 'show']]);
Route::resource('correspondencia', 'CorrespondenciaInternaController', ['only' => ['index', 'show', 'store', 'update']]);

Route::resource('correspondenciagenerada', 'CorrespondenciaInternaGeneradaController', ['only' => ['index', 'show', 'store']]);
