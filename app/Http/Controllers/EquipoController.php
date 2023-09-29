<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Equipo;
use App\Models\Item;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\EquipoService;
use App\Services\TicketService;
use App\Services\ServicioService;
use Illuminate\Support\Facades\DB;

class EquipoController extends Controller
{
    public function index(){
        $tipo_equipo = Item::where('id_categoria',1)->get();
        return  view('equipos.index',compact(
            'tipo_equipo'
        ));
    }
    public function create(){
        $tipo_equipo = Item::where('id_categoria',1)->get();
        $tipo_servicio = Item::where('id_categoria',2)->get();

        // Mandamos a traer los usuarios que tengan rol de tecnicos.

        $tecnicos = User::whereJsonContains('roles',3)->get();

        foreach($tipo_servicio as $tipo ){
            switch ($tipo->descripcion) {
                case 'Mantenimiento':
                    $mantenimiento = $tipo->id_item;
                    break;
                case 'Correccion':
                    $correccion = $tipo->id_item;
                    break;
                case 'Dictamen':
                    $dictamen = $tipo->id_item;
                    break;
                
                default:
                    break;
            }
        }
        return view('equipos.create',compact(
            'tecnicos',
            'tipo_equipo',
            'mantenimiento',
            'correccion',
            'dictamen'
        ));
    }
    
    public function equipoAddtoTicket(Request $request, EquipoService $equipoService){
        // Requisitos obligatorios: Tipo de Equipo / Numero serie

        $rules = [
            'numero_serie' => 'required',
            'tipo_equipo' => 'required',
            'marca' => 'required'
        ];

        $mensajes = [
            'numero_serie.required' => 'El numero de serie es obligatorio',
            'tipo_equipo.required' => 'El tipo de equipo es obligatorio',
            'marca.required' => 'La marca del equipo es obligatorio',
        ];

        $validator = Validator::make($request->all(),$rules,$mensajes);

        if($validator->fails()){
          $result = $validator->errors();
          return  response()->json($result,500);
        }

        // Verificamos que el equipo no exista en estado de En cola en la DB;
        $estado = $equipoService->verificarEquipo($request);
        
        if($estado){
          return  response()->json(['El equipo ya fue ingresado y se encuentra en cola...'],500);
        }

        // Retornamos la vista con los datos insertados.
        return view('equipos.form_equipo_add',[
            'tipo_equipo'=>$request->tipo_equipo,
            'numero_serie'=>$request->numero_serie,
            'marca'=>$request->marca,
            'accesorios'=>$request->accesorios,
            'index'=>$request->index
        ]);
    }

    public function store(Request $request, EquipoService $equipoService, TicketService $ticketService,ServicioService $servicioService){
        if($request->ajax()){
            $rules = [
                'tecnico_revisa'=>'required',
                'equipos_en_lista'=>'different:default0',
                'nip_usuario' => 'required',
                'dependencia_policial'=>'required',
                'servicios_a_realizar'=>'different:default0'
            ];

            $mensajes = [
                'tecnico_revisa.required' => 'Seleccione tecnico que revisa',
                'equipos_en_lista.different' => 'Debe agregar al menos un equipo al ticket',
                'nip_usuario.required' => 'El NIP del usuario es obligatorio',
                'dependencia_policial.required' => 'La dependencia policial del usuario es obligatorio',
                'servicios_a_realizar.different' => 'Debe seleccionar al menos un servicio a realizar'
            ];
            $validator = Validator::make($request->all(),$rules,$mensajes);
            if($validator->fails()){
                $result = $validator->errors();
                return  response()->json($result,500);
            }
            return $request;
        }

        
        try {
    	  DB::beginTransaction();
            $equipo = $equipoService->createEquipo($request);
            $ticket = $ticketService->createTicket($request);
            $servicio = $servicioService->createServicio($request,$ticket,$equipo);
	      DB::commit();
            return redirect()->route('equipo.index')->with('success','Ticket generado satisfactoriamente');
        } catch (\Throwable $th) {
            // El rollback xd
            throw $th;
    	  DB::rollBack();
          return redirect()->back()->with('error','Ocurrio un problema, intente mas tarde o consulte con el administrador del sistema.');
        }
    
    }

    public function showEquipos(){
        $equipos = Equipo::all();
        $estado_equipo = Item::where('id_categoria',3)->get();
        $tipo_equipo = Item::where('id_categoria',1)->get();
        return ['equipos'=>$equipos,'estado_equipo'=>$estado_equipo,'tipo_equipo'=>$tipo_equipo];
    }

    public function show(Request $request){
        // return $request;
        // para que nadie pueda acceder solo con el id del equipo.
        // para traer la data de cada equipo adecuadamente.
        // dd($request->id_equipo);

        // Items necesarios
        $tipo_equipo = Item::where('id_categoria',1)->get();
        $tipo_servicio = Item::where('id_categoria',2)->get();
        $estado_equipo = Item::where('id_categoria',3)->get();
        $estado_ticket = Item::where('id_categoria',4)->get();
        $estado_servicio = Item::where('id_categoria',5)->get();

        // 1. Necesitamos el id del equip, del cual iremos a consultar el ultimo ticket creado con ese id.
        $tickets = Ticket::whereRelation('servicios','id_equipo',$request->id_equipo);
        $last_ticket = $tickets->latest('id_ticket')->first();
        // Obtenemos el servicio actual ordenado -> Mantenimiento -> Correccion -> Dictamen
        $servicio = Servicio::where('id_ticket',$last_ticket->id_ticket)
        ->where('id_equipo',$request->id_equipo)
        ->orderBy('id_servicio','asc')
        ->get();
        $tickets = $tickets->get();
        $equipo = Equipo::where('id_equipo',$request->id_equipo)
        ->whereRelation('servicios','id_equipo',$request->id_equipo)
        ->get();
        $equipos_incluidos = Equipo::whereRelation('servicios','id_ticket',$last_ticket->id_ticket)
        ->whereNot('id_equipo',$request->id_equipo)
        ->get();

        $tecnicos = User::whereJsonContains('roles',3)->get();
        // Mientras tenga estado distinto a 22, estara como el servicio actual.
        foreach($servicio as $disponible){
            if($disponible->id_estado_servicio != 22){ //Automatizar
                $servicio_actual = $disponible;
                break;
            }else{
                $servicio_actual = $servicio->last();
            }
        }





        return view('equipos.show',compact(
            'tecnicos',
            'tickets',
            'servicio',
            'equipo',
            'last_ticket',
            'estado_ticket',
            'tipo_equipo',
            'tipo_servicio',
            'estado_servicio',
            'equipos_incluidos',
            'servicio_actual'
        ));
    }


}
