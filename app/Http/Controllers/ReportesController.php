<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\User;

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
}
