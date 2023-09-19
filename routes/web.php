<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ServicioController;

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
  Route::post('/equipo/store','store')->name('equipo.store');
  Route::post('/equipo/add','equipoAddtoTicket')->name('equipo.add');
  Route::get('/equipo/_equipos','showEquipos')->name('equipo.showEquipos');
  Route::get('/equipo/detalle','show')->name('equipo.show');
});

// Control de Servicios por equipo.

Route::controller(ServicioController::class)->group(function(){
  Route::get('/equipo/servicios','index')->name('servicio.index');
  Route::get('/equipo/servicios/update','update')->name('servicio.update');
});

