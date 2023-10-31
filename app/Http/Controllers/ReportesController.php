<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;

class ReportesController extends Controller
{
    //
    public function index(){
        return view('reportes.index');
    }

    public function servicioPromedio(Request $request){
        $serviciosCorrectivos = Servicio::whereNotNull('fecha_inicio')
        ->whereNotNull('fecha_finalizacion')
        ->where('id_tipo_servicio',12)
        ->get();
        $serviciosPreventivos = Servicio::whereNotNull('fecha_inicio')
        ->whereNotNull('fecha_finalizacion')
        ->where('id_tipo_servicio',11)
        ->get();
        return ['correctivos'=>$serviciosCorrectivos,'preventivos'=>$serviciosPreventivos];
    }
}
