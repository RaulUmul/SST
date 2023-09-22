<?php

namespace App\Http\Controllers;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\Archivo;

class QrCodeController extends Controller
{

    public function index(Request $request){
        // Consultamos si existe el archivo.
        $archivo = Archivo::where('id_equipo',$request->id_equipo)
        ->where('id_tipo_archivo',27);

        $id_equipo = $request->id_equipo;
        $archivo = $archivo->exists();

        return view('qr.index',compact(
            'archivo',
            'id_equipo'
        ));
    }

    // Ya esta el buen QR creado ahora tengo que almacenarlo y recuperarlo
    public function create(Request $request){
        $ruta = $request->ruta.'?id_equipo=3';
        $qr = QrCode::generate($ruta);
        return view('qr.index',compact('qr'))->with('success','QR Generado Correctamente!');
    }

    public function show(){

    }
}
