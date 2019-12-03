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
    return view('index');
});

Route::get('/tareas', 'TareasController@index');

Route::put('/tareas/actualizar', 'TareasController@update');

Route::post('/tareas/guardar', 'TareasController@store');

Route::post('/tareas/borrar/{id}', 'TareasController@destroy');

