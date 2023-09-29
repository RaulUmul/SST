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
<div class="row container">
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
            <a href="#!" class="btn btn-small">Creados</a>
            <a href="#!" class="btn btn-small">Sin asignar</a>
        </div>
        <div >
            <a href="{{route('equipo.create')}}" class="btn btn-small"><i class="right material-icons">add</i>Nuevo</a>
        </div>
    </div>
    @include('partials.divider')
    {{-- Tabla de Los equipos en cola.... --}}
    <div class="col s12">
        <table id="table-equipos" style="width: 100%">
            <thead>
            <tr>
              <th>Tecnico Ingresa</th>
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
      //   Vamos a consultar la data de equipos.
        url:"{{route('equipo.showEquipos')}}",
        type: 'get',
        dataType: 'json',
        data:{},
        beforeSend: function (){},
        success: function (resp) {
          let { data } = resp.equipos;
          console.log(resp.equipos);
          var tablaArmas = $('#table-equipos').addClass('nowrap').DataTable({
            responsive: true,
            "pageLength": 5,
            "order": [ 0, 'desc' ],
            data: resp.equipos,
            columns: [
              {data: 'id_equipo'}, // Tecnico ingresa
              {data: 'id_equipo'}, //Tecnico asignado
              {data: 'id_tipo_equipo',render: function(data){
                let descripcion;
                resp.tipo_equipo.map((tipo)=>{
                    if(data === tipo.id_item){descripcion = tipo.descripcion};
                });
                return descripcion;
              }}, // Tipo
              {data: 'numero_serie'}, // Serie
              {data: 'marca'}, // Marca
              {data: 'id_estado_equipo',render: function(data){
                let descripcion;
                resp.estado_equipo.map((estado)=>{
                    if(data === estado.id_item){descripcion = estado.descripcion};
                });
                return descripcion;
              }}, //Estado
              {data: 'dependencia_policial'}, //Estado
              {data: null}, //Acciones
            //   {data: 'id_tipo_arma',render: function (data){
            //     let descripcion;
            //     resp.tipo_arma.map((tipo)=>{
            //       if(data === tipo.id_item){descripcion = tipo.descripcion};
            //     });
            //     return descripcion;
            //   }},
            //   {data: 'id_marca_arma', render: function (data){
            //       let descripcion;
            //       resp.marca_arma.map((tipo)=>{
            //         if(data === tipo.id_item){descripcion = tipo.descripcion};
            //       });
            //       return descripcion;
            //     }},
            //   {data: 'modelo_arma'},
            //   {data: 'id_calibre', render: function (data){
            //     let descripcion;
            //     resp.calibre_arma.map((tipo)=>{
            //       if(data === tipo.id_item){descripcion = tipo.descripcion}
            //     });
            //     if(descripcion == null){
            //       return null;
            //     }else{
            //       return descripcion;
            //     }
            //   }},
            //   {data: 'licencia'},
            //   {data: 'tenencia'},
            //   {data: 'registro'},
            //   {data: 'id_estatus_arma',render: function (data){
            //       let descripcion;
            //       resp.estado_arma.map((tipo)=>{
            //         if(data === tipo.id_item){descripcion = tipo.descripcion}
            //       });
            //       return descripcion;
            //     }},
            //   null
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

        //   $('#filter-registro').on('keyup',function (){
        //     tablaArmas.columns(7).search(this.value).draw(); // Columna 8 -> registro arma
        //   });

        //   $('#tipo_arma').on('change',function (){
        //     let tipo_arma = $('#tipo_arma option:selected').text();
        //     if(tipo_arma == "N/I"){
        //       tipo_arma = "";
        //     }
        //     tablaArmas.columns(1).search(tipo_arma).draw();
        //   });

        //   $('#estado_arma').on('change',function (){
        //     let estado_arma = $('#estado_arma option:selected').text();
        //     if(estado_arma == "N/I"){
        //       estado_arma = "";
        //     }
        //     tablaArmas.columns(8).search(estado_arma).draw(); //Columna 8 -> estado arma
        //   });

        },
        error: function (response){
          console.log(response)
        },
      });
    });

</script>
@endpush









