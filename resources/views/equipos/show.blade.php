@extends('layouts.plantilla')
@section('title','Detalle Resumen')
@section('content')
    {{-- Aqui mostraremos el detalle del equipo, por lo que necesitaremos el ultimo no. de ticket creado --}}

    {{-- El ticket debera traer todos los equipos, pero el resumen mostrara solo el de cada equipo. --}}
    {{-- @dump($servicio) --}}
    {{-- @dump($tickets) --}}
    {{-- @dump($last_ticket) --}}
    {{-- @dump($equipos_incluidos) --}}

    {{-- Empezemos el diseño del resumen tonces --}}
    <div class="row container">
      @include('partials.divider')
      <div class="col s6 center-align">
        <span>Ticket No. {{$last_ticket->id_ticket}}</span>
      </div>
      <div class="col s6 center-align">
        <span>Estado: 
          @foreach ($estado_ticket as $estado)
            @if ($estado->id_item == $last_ticket->id_estado_ticket) {{$estado->descripcion}} @endif
          @endforeach
        </span>
      </div>
      <div class="col s12 left-align" style="margin-top: 2rem">
        <span>Resumen</span>
      </div>
      @include('partials.divider')
    </div>
    <div class="row container">
      <div class="col s12">
        <span></span>
      </div>
    </div>
    {{-- Collapsible Caracteristicas --}}
    <div class="row container">
      <ul class="collapsible expandable">
        <li class="active">
          <div class="collapsible-header">
            <i class="material-icons">devices</i>
            Caracteristicas
            <span class="badge"><i class="right material-icons">arrow_drop_up</i></span></div>
          <div class="collapsible-body">
            <div class="row">
              <div class="col s6">
                 <p>Tipo:</p> 
                 <p>Marca:</p> 
                 <p>Numero de serie:</p> 
                 <p>Fecha ingreso:</p> 
              </div>
              <div class="col s6 right-align">
                <p><strong> @foreach ($tipo_equipo as $tipo) @if($tipo->id_item == $equipo[0]->id_tipo_equipo ) {{$tipo->descripcion}} @endif @endforeach </strong></p>
                <p><strong>{{$equipo[0]->marca}}</strong></p>
                <p><strong>{{$equipo[0]->numero_serie}}</strong></p>
                <p><strong>{{date('d/m/Y',strtotime($last_ticket->fecha_creacion))}}</strong></p>
              </div>
            </div>
          </div>
        </li>
        {{-- Collapsible Estado --}}
        <li>
          <div class="collapsible-header">
            <i class="material-icons">checklist</i>
            Estado:
            <span class="badge"><i class="material-icons">arrow_drop_down</i></span></div>
          <div class="collapsible-body">
            <div class="row">
              <div class="col s6">
                <p>Servicio actual:</p>
                <p>Tecnico asignado:</p>
                <p>Estado del servicio:</p>
                <p>Estado entrega:</p>
              </div>
              <div class="col s6 right-align">
                <a href="{{route('servicio.index',['servicio'=>json_decode($servicio),'servicio_actual'=>json_decode($servicio_actual)])}}"><strong> @foreach ($tipo_servicio as $tipo) @if($tipo->id_item == $servicio_actual->id_tipo_servicio ) {{$tipo->descripcion}} @endif @endforeach </strong></a>
                <p><strong>
                  @empty($servicio_actual->id_tecnico_asignado)
                   Sin asignar
                  @else
                    @foreach ($tecnicos as $tecnico)
                    @if ($tecnico->id_usuario == $servicio_actual->id_tecnico_asignado)
                      {{$tecnico->nombres.' '.$tecnico->apellidos}}
                    @endif
                    @endforeach 
                  @endempty
                </strong></p>
                <p><strong>@foreach ($estado_servicio as $estado) @if($estado->id_item == $servicio_actual->id_estado_servicio ) {{$estado->descripcion}} @endif @endforeach </strong></p>
                {{-- Vamos a validar si ya esta entregado, nos aparece fecha de entrega, pero si aun no esta entregado que aparezca Listo para entregar cuando ya este finalizado todos los servicios. --}}
                @auth

                  @if ($last_ticket->fecha_entrega != null)
                    Entregado {{date('d/m/Y',strtotime($last_ticket->fecha_entrega))}}
                  @else
                    @if ($last_ticket->fecha_entrega == null && $equipo[0]->id_estado_equipo == 16)
                    <p> <strong><a href="#modEntregaEquipo" class="modal-trigger">Listo para entregar</strong></a></p>
                    @else
                    Pendiente
                    @endif
                  @endif

                @endauth

                @guest
                  @if ($last_ticket->fecha_entrega != null)
                    Entregado {{date('d/m/Y',strtotime($last_ticket->fecha_entrega))}}
                  @else
                    Pendiente
                  @endif
                @endguest
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="row container">
      @if(isset($tickets))
          
      <div class="col s12 right-align">
        {{-- @dd($tickets) --}}
        {{-- Hay que validar si existen tickets anteriores, se muestra, si no no --}}
        {{-- Hay que enviarlo por POST --}}
        <form action="{{route('equipo.oldTickets')}}" method="POST" id="ticketsForm">
          @csrf
          <input type="hidden" name="tickets" value="{{$tickets}}">
          <input type="hidden" name="id_equipo" value="{{$equipo[0]->id_equipo}}">
          {{-- <a href="{{route('equipo.oldTickets',['tickets'=>json_encode($tickets)])}}">Ver tickets anteriores</a> --}}
          <button class="btn">
            Ver tickets anteriores...
          </button>
        </form>
      </div>
      @endif
    </div>
    {{-- Equipos Incluidos en ticket --}}
    <div class="row container">
      <div class="col s12 left-align" style="">
        <span>Equipos incluidos en ticket</span>
      </div>
      @include('partials.divider')

      <div class="col s12">
        <div class="collection">
          @foreach ($equipos_incluidos as $incluido)
            <a href="{{route('equipo.show',['id_equipo'=>$incluido->id_equipo])}}" class="collection-item">
              <span class="badge">
                Ver...
              </span>
              @foreach ($tipo_equipo as $tipo) @if($tipo->id_item == $incluido->id_tipo_equipo ) {{$tipo->descripcion}} @endif @endforeach 
              / Serie: 
              {{$incluido->numero_serie}}
            </a>
          @endforeach
        </div>
      </div>
    </div>

    {{-- Modals --}}
    <div id="modEntregaEquipo" class="modal">
      <div class="modal-content center-align">
        <h4>Entregar Equipo</h4>
        <form id="formEntregaEquipo" method="POST" action="{{route('equipo.entrega')}}">
          @csrf
          <input id="id_equipo" name="id_equipo" type="hidden" value="{{$equipo[0]->id_equipo}}">
          <input id="id_ticket" name="id_ticket" type="hidden" value="{{$last_ticket->id_ticket}}">
          <div class="input-field col s6">
            <input id="nip_usuario" name="nip_usuario" type="text" class="validate">
            <label for="nip_usuario">NIP Usuario recibe equipo</label>
          </div>
          <button class="btn" onclick="entregaEquipo(event)">
            Entregado
          </button>
        </form>
      </div>
    </div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const collapsibles = document.querySelectorAll('.collapsible.expandable>li');
    collapsibles.forEach(function(collapsible) {
      collapsible.addEventListener('click', function() {
        const isActive = collapsible.classList.contains('active');
        const badge = this.querySelector('.badge i.material-icons');
        (isActive) ? badge.textContent = 'arrow_drop_down' : badge.textContent = 'arrow_drop_up';
      });
    });

    var modalEntregaEquipo = document.querySelectorAll('.modal');
    M.Modal.init(modalEntregaEquipo);


  });

  
  function entregaEquipo(e) {
      e.preventDefault();
      let nip_usuario = $('#nip_usuario').val();
      let id_equipo = $('#id_equipo').val();
      let id_ticket = $('#id_ticket').val();
      $.ajax({
        type: 'POST' ,
        url: "{{route('equipo.entrega')}}",
        data: {
          nip_usuario,
          id_equipo,
          id_ticket,
          _token:'{{ csrf_token() }}'
        },
        dataType: "text",
        success: function (response) {
          $('#formEntregaEquipo').submit();
        },
        error: function(response){
          if(JSON.parse(response.responseText)){
          let errores = Object.values(JSON.parse(response.responseText));
          errores.map(el => {
            M.toast({html: `<span><i class="material-icons left">error</i></span><span>${el}</span>`});
            }
          )
        }
        }
      });
    }
</script>
@endpush