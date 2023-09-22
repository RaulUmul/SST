<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Services\EquipoService;
use DateTime;
use Illuminate\Http\Request;

class ServicioController extends Controller
{

    public function index(Request $request){
        // Desde aca enviaremos el historial de servicios si existiera.
        $servicio_actual = Servicio::find($request->servicio_actual['id_servicio']);
        return view('servicios.index',['data'=>$servicio_actual,'servicio'=>$request->servicio]);
    }

    public function update(Request $request,EquipoService $equipoService){
        // Nos quedamos aqui..... -> resulta que servicio siempre va a traer a todos
        // los servicios nuevamente, por lo que nunca va a quedar en null, 
        // debemos traer servicio con filtro desde la DB, indicando que servicio != estado 22
        // $servicio = $request->servicio;

        $fecha_guardada = new DateTime();
        $fecha_guardada = date('d-m-Y h:i:s',$fecha_guardada->getTimestamp());

        if($request->columna_registrar == 'Iniciar'){
            $servicio_actualizar = Servicio::find($request->actual);
            $servicio_actualizar->fecha_inicio = $fecha_guardada;
            $servicio_actualizar->id_estado_servicio = 21; //Automatizar
            $servicio_actualizar->save();
        }

        if($request->columna_registrar == 'Finalizar'){
            $servicio_actualizar = Servicio::find($request->actual);
            $servicio_actualizar->fecha_finalizacion = $fecha_guardada;
            $servicio_actualizar->id_estado_servicio = 22; //Automatizar
            $servicio_actualizar->save();

            // Eliminamos el servicio actual del arreglo, ya que ya finalizo
            // Y debe unicamente interactuar con los actuales.

            $servicio = Servicio::where('id_equipo',$servicio_actualizar->id_equipo)
            ->whereNot('id_estado_servicio',22)
            ->orderBy('id_servicio','asc')
            ->get()
            ->toArray();

            // dd($request->actual,$servicio);

            // Domingo, me quede aqui...
            foreach($servicio as $key => $value){
                if($value["id_servicio"] === $request->actual) unset($servicio[$key]);
            }   

            if($servicio != null){
                $servicio = array_values($servicio);
                $servicio_actualizar = $servicio[0];
            }else{
                // Si esta vacio el listado de servicios, hemos terminado los servicios.
                // Dejamos a servicio actualizar como el activo.
                // Procedemos a cambiar el estatus del equipo a finalizado...
                // dd($servicio_actualizar->id_equipo);
                $estado = 16;
                $equipoService->updateEstado($servicio_actualizar->id_equipo, $estado);
            }

            // Asignamos a servicio actual al siguiente arreglo en $servicio.
        }

        // return response()->json(['servicio_actual'=>$servicio_actualizar,'servicio'=>$servicio],200);
    }

}
 