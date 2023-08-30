<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipoController;

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

// Inicio Sistec
Route::view('/','welcome')->name('sistec.index');


// Ingreso de Equipos

Route::controller(EquipoController::class)->group(function(){
  Route::get('/equipo/','index')->name('equipo.index');
  Route::get('/equipo/create','create')->name('equipo.create');
});
