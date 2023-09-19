<?php

namespace App\Services;

use App\Models\Equipo;
use App\Models\Ticket;
use App\Models\Item;
use Illuminate\Http\Request;

class TicketService{

  public function createTicket(Request $request):Ticket{

    $ticket = new Ticket();
      // $ticket->numero_documento = $request->numero_documento;     
      // $ticket->id_archivo_referencia = $request->id_archivo_referencia;     
      // $ticket->id_tecnico_revisa = $request->tecnico_revisa;     
      // $ticket->id_tecnico_revisa = 1;     
      $ticket->nip_usuario_ingresa = $request->nip_usuario;     
      // $ticket->nip_usuario_recibe = $request->nip_usuario;     
      $ticket->fecha_creacion = $request->fecha_ingreso;     
      // $ticket->fecha_entrega = $request->fecha_entrega;     
      $ticket->id_estado_ticket = 18; //Automatizar -> quemado.     
    $ticket->save();

    return $ticket;
  }

  public function updateTicket(){
    // Actualiza la informacion del ticket. (solo el estado creo)
  }

}
