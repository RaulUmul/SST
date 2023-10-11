<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\AuthController;


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
Route::view('/','welcome')->name('sistec.index')->middleware('auth');
// Login
Route::view('/login','login.login')->name('login.index');
Route::post('/login',[AuthController::class,'login'])->name('login');
// Registro
Route::view('/registro','login.registro')->name('registro.index');
Route::post('/registro',[AuthController::class,'registro'])->name('registro.create');
// Logout
Route::get('logout',[AuthController::class,'logout'])->name('logout');

// Ingreso de Equipos

Route::controller(EquipoController::class)->group(function(){
  Route::get('/equipo/','index')->name('equipo.index')->middleware('auth');
  Route::get('/equipo/create','create')->name('equipo.create')->middleware('auth','role:Tecnico');
  Route::post('/equipo/store','store')->name('equipo.store');
  Route::post('/equipo/add','equipoAddtoTicket')->name('equipo.add');
  Route::get('/equipo/_equipos','showEquipos')->name('equipo.showEquipos')->middleware('auth');
  Route::get('/equipo/detalle','show')->name('equipo.show');
  Route::get('/equipo/detalle_ticket','show_especifically_ticket')->name('equipo.show_especifically');
  Route::post('/equipo/entrega','entrega')->name('equipo.entrega');
  Route::post('/equipo/anteriores_tickets','oldTickets')->name('equipo.oldTickets');
});

// Control de Servicios por equipo.

Route::controller(ServicioController::class)->group(function(){
  Route::get('/equipo/servicios','index')->name('servicio.index');
  Route::get('/equipo/servicios/update','update')->name('servicio.update')->middleware('auth');
});

// Control de QR code

Route::controller(QrCodeController::class)->group(function(){
  Route::get('/qrhome','index')->name('qr.index');
  Route::get('/qrcrear','create')->name('qr.create');
  Route::get('/qrgenerado','show')->name('qr.show');
  Route::get('/qrsearch','search')->name('qr.search');
  Route::get('/qrdownload','downloadQR')->name('qr.download');
});
// Control de archivos tipo Dictamen / Oficio
Route::controller(ArchivoController::class)->group(function(){
  Route::post('/cargarDictamen','cargar_dictamen')->name('archivo.dictamen');
  Route::post('/actualizarDictamen','update_dictamen')->name('update.dictamen');
  Route::get('/visualizarDictamen','show_dictamen')->name('show.dictamen');
});

// Control de Usuario
Route::controller(UsuariosController::class)->group(function(){
  Route::get('/consulta_usuario','index')->name('usuario.index')->middleware('role:Tecnico Admon');
  Route::get('/buscar_usuario','buscar')->name('usuario.search')->middleware('role:Tecnico Admon');
  Route::post('/actualizar_roles','update_roles')->name('update.roles')->middleware('role:Tecnico Admon');
});


