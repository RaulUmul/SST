<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\User;
use DateTime;

class ReportesController extends Controller
{
    //
    public function index(){

        $tecnicos = User::whereJsonContains('roles',3)->get();


        return view('reportes.index',compact('tecnicos'));
    }

    public function servicioPromedio(Request $request){


        $tecnico_asignado = $request->tecnico;

        $serviciosCorrectivos = Servicio::whereNotNull('fecha_inicio')
        ->whereNotNull('fecha_finalizacion')
        ->where('id_tipo_servicio',12);

        if($tecnico_asignado != null) 
            $serviciosCorrectivos = $serviciosCorrectivos->where('id_tecnico_asignado',$tecnico_asignado);

        $serviciosCorrectivos = $serviciosCorrectivos->get();

        $serviciosPreventivos = Servicio::whereNotNull('fecha_inicio')
        ->whereNotNull('fecha_finalizacion')
        ->where('id_tipo_servicio',11);
        
        if($tecnico_asignado != null) 
            $serviciosPreventivos = $serviciosPreventivos->where('id_tecnico_asignado',$tecnico_asignado);

        $serviciosPreventivos = $serviciosPreventivos->get();
        
        return ['correctivos'=>$serviciosCorrectivos,'preventivos'=>$serviciosPreventivos];
    }

    public function totalTrabajados(Request $request){

        $L = '';
        $ultimo_dia_mes = '';

        if($request->fecha_inicio != null){
            $fecha_inicio = date("2023-".$request->fecha_inicio."-01");
            // Obtener el ultimo dia del mes
            $L = new DateTime( $fecha_inicio ); 
            $ultimo_dia_mes = $L->format( 't' );
        }
            
        if($request->fecha_final != null){
            // Se proporciono fecha_final
            $fecha_referencia = date("2023-".$request->fecha_final."-01");
            $L = new DateTime( $fecha_referencia ); 
            $ultimo_dia_mes = $L->format( 't' );
            $fecha_final = date("2023-".$request->fecha_final."-$ultimo_dia_mes");
        }
        
        if($request->fecha_final == null)
            // No se proporciono fecha_final
            $fecha_final = date("2023-".$request->fecha_inicio."-$ultimo_dia_mes");
            
        // Como fregados le mandamos a cada mes esa babosada.
        // Esto solo es cuando hay seleccionado rangos.
        // if($request->fecha != null){
            $servicios = Servicio::select('id_ticket')
            ->whereNotNull('fecha_finalizacion')
            ->whereBetween('fecha_finalizacion',[$fecha_inicio,$fecha_final])
            ->distinct()
            ->get();
            return $servicios;
        // }else{
            // $servicios = Servicio::where()
        // }
        return $request->all();

    }
}
