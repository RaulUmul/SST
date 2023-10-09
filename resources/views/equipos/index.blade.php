@extends('layouts.plantilla')
@section('title','Equipos')
@push('styles')
    <style>
        main,footer{
            padding-left: 0;
        }
    </style>
@endpush
@section('ocultar','hide-on-large-only')
@section('content')
<div class="row container" style="width: 90%">
    {{-- Title --}}
    <div class="col s12 center-align">
        <h2>Equipos</h2>
    </div>
    <div class="col s12">
        <div class="divider"></div>
    </div>
    {{-- Section Buttons --}}
    <div class="col s12" style="display: flex; gap: 0px; justify-content: space-between; margin-top: 2rem; margin-bottom: 2rem">
        <div>
            <a href="#!" class="btn btn-small" id="allEquipos" >Todos</a>
            <a href="#!" class="btn btn-small" id="asignados_me" data-key="{{auth()->user()->nombres.' '.auth()->user()->apellidos}}">Mis asignados</a>
        </div>
        <div>
            <a  href="{{route('equipo.create')}}" class="btn btn-small"><i class="right material-icons">add</i>Nuevo</a>
        </div>
    </div>

    <div class="input-field col s12 m6 center">
      <input placeholder="Numero de serie" id="serie" type="text" class="validate">
      <label for="serie">No. Serie / SN</label>
    </div>
    <div class="input-field col s12 m6 center">
      <input placeholder="Numero de ticket" id="ticket" type="number" class="validate">
      <label for="serie">No.Ticket</label>
    </div>
    @include('partials.divider')
    {{-- Tabla de Los equipos en cola.... --}}
    <div class="col s12">
        <table id="table-equipos" style="width: 100%">
            <thead>
            <tr>
              <th>Tecnico Revisó</th>
              <th>Tecnico Asignado</th>
              <th>Tipo</th>
              <th>Serie</th>
              <th>Marca</th>
              <th>Estado</th>
              <th>Dependencia Policial</th>
              <th>Acciones</th>
            </tr>
            </thead>
          </table>
    </div>

</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $.ajax({
      //   {{--Vamos a consultar la data de equipos.--}}
        url:"{{route('equipo.showEquipos')}}",
        type: 'get',
        dataType: 'json',
        data:{},
        beforeSend: function (){},
        success: function (resp) {
          let { data } = resp.equipos;
          let { tecnicos } = resp.tecnicos;
          console.log(resp.equipos);
          var tablaArmas = $('#table-equipos').addClass('nowrap').DataTable({
            responsive: true,
            "pageLength": 5,
            "order": [ 0, 'desc' ],
            data: resp.equipos,
            columns: [
              {data: 'servicios',render: function (data){
                let descripcion;
                let ticket;
                data.map(el=>{
                  ticket = el.id_ticket;
                })
                // {{-- El tecnico reviso siempre es obligatorio --}}
                resp.tickets.map(elem=>{
                  if(elem.id_ticket == ticket){
                    descripcion = elem.id_tecnico_revisa;
                  }
                })

                let nombres, apellidos;
                resp.tecnicos.map(element => {
                  if(element.id_usuario == descripcion){
                    nombres = element.nombres;
                    apellidos = element.apellidos;
                  }
                });
                descripcion = `<i class=" material-icons left">person</i>${nombres} ${apellidos}`;

                return descripcion;
              }}, // {{--Tecnico ingresa--}}
              {data: 'servicios',render: function (data){
                let descripcion;

                data.map(el=>{
                  if(el.id_tecnico_asignado == null){
                    descripcion = `<i class=" material-icons left">person</i> Sin asignar`;
                  }else{
                    descripcion = el.id_tecnico_asignado;
                  }
                })

                if(descripcion != `<i class=" material-icons left">person</i> Sin asignar`){
                  let nombres, apellidos;
                  resp.tecnicos.map(element => {
                    if(element.id_usuario == descripcion){
                      nombres = element.nombres;
                      apellidos = element.apellidos;
                    }
                  });
                  descripcion = `<i class=" material-icons left">person</i>${nombres} ${apellidos}`;
                }

                return descripcion;
              }}, //{{--Tecnico asignado--}}
              {data: 'id_tipo_equipo',render: function(data){
                let descripcion;
                resp.tipo_equipo.map((tipo)=>{
                    if(data === tipo.id_item){descripcion = `<i class=" material-icons left">devices</i> ${tipo.descripcion}`};
                });
                return descripcion;
              }}, // {{--Tipo--}}
              {data: 'numero_serie'}, // {{--Serie--}}
              {data: 'marca'}, // {{--Marca--}}
              {data: 'id_estado_equipo',render: function(data){
                let descripcion;
                resp.estado_equipo.map((estado)=>{
                    if(data === estado.id_item){descripcion = estado.descripcion};
                });
                return descripcion;
              }}, 
              {data: 'dependencia_policial'},
              {data: null}, //Acciones
            ],
            // select: true,
            dom: 'Brtip',
            columnDefs:[
                {target: 2 ,responsivePriority: 1},
                {target: 3 ,responsivePriority: 2},
              {
                target: -1,
                responsivePriority: 3,
                visible: true,
                data: 'id_equipo',
                orderable: false,
                render: function ( data, type, row, meta ) {
                  
                 return  `
                 <div class="row">
                  <div class="col s6">
                   <form action="{{route('equipo.show')}}">
                     <input type="hidden" name="id_equipo" value="${data.id_equipo}">
                     <button type="submit" class="btn"> <i class="material-icons">visibility</i></button>
                     </form>
                  </div>

                  <div class="col s6">
                  <form action="{{route('qr.index')}}">
                  <input type="hidden" name="id_equipo" value="${data.id_equipo}">
                  <button type="submit" class="btn"> <i class="material-icons">qr_code</i></button>
                  </form>
                  </div>
                 </div>
                 `;
                }
              }
            ],
            // "bDestroy": true
          });

          $('#asignados_me').on('click',function (event){
            // console.log();
            tablaArmas.columns(1).search($(this).data('key')).draw(); // Columna 8 -> registro arma
          });

          $('#allEquipos').on('click',function(){
            tablaArmas.columns().search('').draw();            
          });

          $('#serie').on('keyup',function (){
            tablaArmas.columns(3).search(this.value).draw(); // Columna 8 -> registro arma
          });

        },
        error: function (response){
          console.log(response)
        },
      });
    });

</script>
@endpush









