<?php

namespace App\Services;

use App\Models\Equipo;
use App\Models\Servicio;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ServicioService{

  public function createServicio(Request $request,Ticket $ticket,$equipo){

    // Recorremos la cantidad de quipos y le asignamos el tipo de servicio segun el request a cada uno.
    // Segun cantidad de servicios, crearemos los servicios a cada equipo ingresado.

    // Guardamos en un arreglo, los que este presentes, y segun quien esta presente
    // le asignamos cada servicio a cada equipo.
    $servicios_presentes = [];
    isset($request->mantenimiento) && $servicios_presentes[] = $request->mantenimiento;
    isset($request->correccion) && $servicios_presentes[] = $request->correccion;
    isset($request->dictamen) && $servicios_presentes[] = $request->dictamen;
    // dd($servicios_presentes);
    // $datosEquipos = Arr::add($datosEquipos,$key,$value);


    foreach($equipo as $key => $value){
      foreach($servicios_presentes as $aRealizar){
        $servicio = new Servicio();
          $servicio->id_ticket = $ticket->id_ticket;
          $servicio->id_equipo = $value->id_equipo;
          // $servicio->id_tecnico_asignado = $request->tecnico_asignado;
          // $servicio->id_tecnico_asignado = 2; //Automatizar
          $servicio->id_tipo_servicio = $aRealizar; //Automatizar
          // $servicio->fecha_inicio = ; //Automatizar -> Aun no se como manejarlo.
          // $servicio->fecha_finalizacion = ; //Automatizar -> Aun no se como manejarlo.
          $servicio->id_estado_servicio = 20; //Automatizar
        $servicio->save();
      }
    }
    return 'Creados satisfactoriamente';
  }
}