<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archivo;
use App\Models\Servicio;
use App\Services\EquipoService;
use DateTime;


class ArchivoController extends Controller
{

    // Manejamos la carga del dictamen y 
    public function cargar_dictamen(Request $request, EquipoService $equipoService){
        if ($request->hasFile('file')) {
            if($request->file('file')->isValid()){
                if($request->file('file')->getClientOriginalExtension() != 'pdf'){
                  return back()->with('error','Solo se puede cargar documentos PDF');
                }
                // Variables para guardar el tiempo de actualizacion del servicio (Dictamen).
                $fecha_guardada = new DateTime();
                $fecha_guardada = date('d-m-Y h:i:s',$fecha_guardada->getTimestamp());
        
                $nombre_hash = $request->file('file')->store('dictamenes');
                // Guardacion del archivo.
                $archivo = new Archivo();
                $archivo->id_equipo = $request->id_equipo;
                $archivo->id_tipo_archivo = 26; //Automatizar
                $archivo->nombre = $request->file('file')->getClientOriginalName();
                $archivo->nombre_hash = $nombre_hash;
                $archivo->mime = $request->file('file')->getClientMimeType();
                $archivo->save();

                // Realizamos el registro del servicio dictamen...


                // 1. Hacemos la consulta de Servicio
                $servicio = Servicio::where('id_ticket',$request->id_ticket)
                ->where('id_equipo',$request->id_equipo)
                ->where('id_tipo_servicio',13); //Automatizar


                if($servicio->exists()){
                    // Registramos el servicio dictamen
                    $servicio_update = Servicio::find($servicio->first()->id_servicio);
                    $servicio_update->fecha_inicio = $fecha_guardada;
                    $servicio_update->fecha_finalizacion = $fecha_guardada;
                    $servicio_update->id_estado_servicio = 22; //Automatizar
                    $servicio_update->save();
                }else if($servicio->doesntExist()){
                    // En caso no exista... Creamos el registro
                    $servicio = new Servicio();
                    $servicio->id_ticket = $request->id_ticket;
                    $servicio->id_equipo = $request->id_equipo;
                    $servicio->id_tecnico_asignado = auth()->user()->id_usuario;
                    $servicio->id_tipo_servicio = 13; // Automatizar
                    $servicio->fecha_inicio = $fecha_guardada;
                    $servicio->fecha_finalizacion = $fecha_guardada;
                    $servicio->fecha_finalizacion = $fecha_guardada;
                    $servicio->id_estado_servicio = 22; //Automatizar
                    $servicio->save();
                }

                // Evaluamos si es el ultimo servicio para cargarle estado de finalizado al equipo.
                $otherServicio = Servicio::where('id_equipo',$request->id_equipo)
                ->whereNot('id_estado_servicio',22)
                ->orderBy('id_servicio','asc')
                ->get()
                ->toArray();

                if($otherServicio == null){
                    $estado = 16; //Automatizar
                    $equipoService->updateEstado($request->id_equipo, $estado);
                }

                return back()->with('success','Archivo cargado y guardado correctamente');
            }
        }else{
            // return 'No hay archivo o no se cargo correctamente';
            return back()->with('error','No hay archivo o no se cargo correctamente');
        }
    }

    public function update_dictamen(Request $request, EquipoService $equipoService){
        // dd($request->all());
        if($request->hasFile('file')){
            if($request->file('file')->isValid()){
                $nombre_hash = $request->file('file')->store('dictamenes');
                $fecha_guardada = new DateTime();
                $fecha_guardada = date('d-m-Y h:i:s',$fecha_guardada->getTimestamp());
                // Actualizamos
                $id_archivo = Archivo::select('id_archivo')
                ->where('id_tipo_archivo',26)
                ->where('id_equipo',$request->id_equipo)
                ->first();

                $archivo = Archivo::find($id_archivo->id_archivo);
                \Storage::delete($archivo->nombre_hash); //El comportamiento es, archivo actualizado, archivo borrado, es correcto? o debemos almacenar por seguridad ese pdf?
                $archivo->nombre = $request->file('file')->getClientOriginalName();
                $archivo->nombre_hash = $nombre_hash;
                $archivo->mime = $request->file('file')->getClientMimeType();
                $archivo->save();

                $servicio = Servicio::where('id_ticket',$request->id_ticket)
                ->where('id_equipo',$request->id_equipo)
                ->where('id_tipo_servicio',13); //Automatizar

                // Actualizamos el servicio
                $servicio_update = Servicio::find($servicio->first()->id_servicio);
                $servicio_update->fecha_inicio = $fecha_guardada;
                $servicio_update->fecha_finalizacion = $fecha_guardada;
                $servicio_update->id_estado_servicio = 22; //Automatizar
                $servicio_update->save();

                $otherServicio = Servicio::where('id_equipo',$request->id_equipo)
                ->whereNot('id_estado_servicio',22)
                ->orderBy('id_servicio','asc')
                ->get()
                ->toArray();

                if($otherServicio == null){
                    $estado = 16; //Automatizar
                    $equipoService->updateEstado($request->id_equipo, $estado);
                }

                return back()->with('success','Se cambio correctamente');

            }
        }else{
            return back()->with('error','No realizo cambios o no se cargo correctamente el archivo');
        }
    }

    public function show_dictamen(Request $request){
        $archivo = \Storage::get($request->nombre_hash);
        return response($archivo,200)->header('Content-Type','application/pdf');
    }
}
