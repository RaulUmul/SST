<?php

namespace App\Services;

use App\Models\Equipo;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class EquipoService{

  public function createEquipo(Request $request){

	  $patron = "/equipo_/";
    $datosEquipos=[];
    $equiposAlmacenados=[];
    foreach($request->all() as $key => $value){
      if(preg_match($patron,$key,$coincidencias)){
      $datosEquipos = Arr::add($datosEquipos,$key,$value);
      }
    }

    foreach($datosEquipos as $key => $dato){
      // dd($dato);

      $equipo = Equipo::where('id_tipo_equipo',$dato['tipo_equipo'])
      ->where(function ($q)  use ($dato) {
        $q->where('numero_serie',$dato['numero_serie'])
          ->Where('marca',$dato['marca']);
      });


      if($equipo->doesntExist()){
        $equipo = new Equipo();
          $equipo->id_tipo_equipo = $dato['tipo_equipo'];
          $equipo->numero_serie = strtoupper($dato['numero_serie']);
          $equipo->marca = strtoupper($dato['marca']);
          // $equipo->modelo = $dato['modelo'];
          $equipo->accesorios = strtoupper($dato['accesorios']);
          $equipo->dependencia_policial = strtoupper($request->dependencia_policial);
          $equipo->id_estado_equipo = 14;
        $equipo->save();
        // $equiposAlmacenados = Arr::add($equiposAlmacenados,$key,$equipo);
      }else if($equipo->exists()){
        $equipo = Equipo::find($equipo->first()->id_equipo);
        $equipo->accesorios = strtoupper($dato['accesorios']);
        $equipo->dependencia_policial = strtoupper($request->dependencia_policial);
        $equipo->id_estado_equipo = 14;
        $equipo->save();
        // $equiposAlmacenados = Arr::add($equiposAlmacenados,$key,$equipo);
      }
        $equiposAlmacenados = Arr::add($equiposAlmacenados,$key,$equipo);
    }
    return $equiposAlmacenados;
  }

  public function verificarEquipo(Request $request):bool{
    $estados_equipo = Item::where('id_categoria',3)->get(); //Automatizar
    $inCola='';
    $inMantenimiento='';
    $inFinalizado='';
    $inEntregado='';

    foreach($estados_equipo as $item ){
			switch ($item->descripcion) {
				case ('En cola'):
					$inCola = $item->id_item;
					break;

				case ('Mantenimiento'):
					$inMantenimiento = $item->id_item;
					break;

				case ('Finalizado'):
					$inFinalizado = $item->id_item;
					break;
				case ('Entregado'):
					$inEntregado = $item->id_item;
					break;
			}
		}

    $equipo = Equipo::where('id_tipo_equipo',$request->tipo_equipo)
                    ->where(function ($q)  use ($request,$estados_equipo) {
                      $q->where('numero_serie',$request->numero_serie)
                        ->Where('marca',$request->marca);
                    })
                    ->where(function ($q) use ($inCola,$inMantenimiento,$inFinalizado){
                       $q->orWhere('id_estado_equipo',$inCola)
                         ->orWhere('id_estado_equipo',$inMantenimiento)
                         ->orWhere('id_estado_equipo',$inFinalizado);
                    });

    return  $equipo->exists() ? true : false;
  }

  public function updateEstado($id_equipo,$estado){
    
    $equipo = Equipo::find($id_equipo);
      $equipo->id_estado_equipo = $estado;
    $equipo->save();

  }

}
