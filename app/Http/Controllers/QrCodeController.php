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

        if($archivo){
            // Vamos a traernos la informacion del archivo y como lo devolveremos?
            $archivo = Archivo::where('id_equipo',$id_equipo)
            ->where('id_tipo_archivo',27) //Automatizar 
            ->first();
            // $archivo = \Storage::disk('qrcode')->get($archivo->nombre_hash);
            // dd($archivo);
            // return response($archivo,200)->header('Content-Type','image/svg+xml');
        }

        return view('qr.index',compact(
            'archivo',
            'id_equipo'
        ));
    }

    // Ya esta el buen QR creado ahora tengo que almacenarlo y recuperarlo
    public function create(Request $request){
        $ruta = $request->ruta.'?id_equipo='.$request->id_equipo;
        $nombre_archivo = 'qr_equipo_'.$request->id_equipo.'.png';
        $nombre_hash = \Hash::make($nombre_archivo);
        $qr = \QrCode::format('png')
        // ->merge(public_path('img/logoPNC.png'), 0.3, true)
        ->size(5000)
        // ->backgroundColor(255, 255, 0)
        // ->color(255, 0, 127)
        ->generate($ruta);
        // Guardamos el qr.
        \Storage::disk('qrcode')->put($nombre_archivo,$qr);
        // Ya guardado, almacenamos en la tabla de Archivo.

        $archivo = new Archivo();
        $archivo->id_equipo = $request->id_equipo;
        $archivo->id_tipo_archivo = 27; //Automatizar.
        $archivo->nombre = $nombre_archivo;
        $archivo->nombre_hash = $nombre_hash;
        // Me falta el mime xD
        $archivo->save();

        return redirect()->back()->with('success','QR Generado Correctamente!');
    }
    // 
    public function show(){

    }

    public function downloadQR(Request $request){
        $archivo = json_decode($request->archivo);
        // return ;
        // $ruta = 'https://www.google.com';
        // $fileDest = storage_path('app/qrcode.svg'); 
        // QrCode::size(400)->generate($ruta, $fileDest);
        return response()->download(storage_path('app/qrcodes/'."$archivo->nombre"));
    }

    public function search(){
        return view('qr.search');
    }
}
