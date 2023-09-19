@extends('layouts.plantilla')
@section('title','Detalle Resumen')
@section('content')
    {{-- Aqui mostraremos el detalle del equipo, por lo que necesitaremos el ultimo no. de ticket creado --}}

    {{-- El ticket debera traer todos los equipos, pero el resumen mostrara solo el de cada equipo. --}}
    {{-- @dump($servicio) --}}
    {{-- @dump($ticket) --}}
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
                <p>Fecha de entrega:</p>
              </div>
              <div class="col s6 right-align">
                <a href="{{route('servicio.index',['servicio'=>json_decode($servicio),'servicio_actual'=>json_decode($servicio_actual)])}}"><strong> @foreach ($tipo_servicio as $tipo) @if($tipo->id_item == $servicio_actual->id_tipo_servicio ) {{$tipo->descripcion}} @endif @endforeach </strong></a>
                <p><strong> - {{$servicio_actual->id_tecnico_asignado}}</strong></p>
                <p><strong>@foreach ($estado_servicio as $estado) @if($estado->id_item == $servicio_actual->id_estado_servicio ) {{$estado->descripcion}} @endif @endforeach </strong></p>
                <p><strong> Pendiente </strong></p>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="row container">
      <div class="col s12 right-align">
        <a href="#!">Ver tickets anteriores...</a>
      </div>
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
  });
</script>
@endpush