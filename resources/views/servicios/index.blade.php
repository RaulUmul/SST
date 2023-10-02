@extends('layouts.plantilla')
@section('title','Detalle Servicios')
@section('content')

{{-- Un formulario para capturar el inicio y la finalizacion --}}
 {{-- El texto del enlace que registraTimeStamp(this)-> "Iniciar " o "Finalizar " <-Debe contener un espacio. --}}
{{-- @dd($data) --}}
<form action="" id="mantenimiento">
  <div class="row container">
    <div class="col s12">
      <p>Mantenimiento</p>
    </div>
    <div class="col s12 center-align btns_time">
      <a href="#!" onclick="registraTimeStamp(this)" class="green btn" val="hola">Iniciar <i class="left material-icons">play_circle</i></a>
      <a href="#!" onclick="registraTimeStamp(this)" class="red btn">Finalizar <i class="left material-icons">stop_circle</i></a>
      {{-- El resumen debe de activarse hasta que finalice el mantenimiento --}}
      <div class="input-field col s12">
        <textarea id="resumen_mantenimiento" name="resumen_mantenimiento" class="materialize-textarea"></textarea>
        <label for="resumen_mantenimiento">Resumen/Observacion</label>
      </div>
    </div>
    @include('partials.divider')
  </div>
</form>
{{-- Form Correccion --}}
<form action="" id="correccion">
  <div class="row container">
    <div class="col s12">
      <p>Correccion</p>
    </div>
    <div class="col s12 center-align btns_time">
      <a href="#!" onclick="registraTimeStamp(this)" class="green btn">Iniciar <i class="left material-icons">play_circle</i></a>
      <a href="#!" onclick="registraTimeStamp(this)" class="red btn">Finalizar <i class="left material-icons">stop_circle</i></a>
      {{-- El resumen debe de activarse hasta que finalice el mantenimiento --}}
      <div class="input-field col s12">
        <textarea id="resumen_correccion" name="resumen_correccion" class="materialize-textarea"></textarea>
        <label for="resumen_correccion">Resumen/Observacion</label>
      </div>
    </div>
    @include('partials.divider')
  </div>
</form>
{{-- Form Dictamen --}}
@empty($archivo)
    
  <form action="{{route('archivo.dictamen')}}" method="post" id="dictamen" enctype="multipart/form-data">

    @csrf
    <input type="hidden" name="id_equipo" value="{{$data->id_equipo}}">
    <input type="hidden" name="id_ticket" value="{{$data->id_ticket}}">

    <div class="row container">
      <div class="col s12">
        <p>Dictamen</p>
      </div>
      <div class="col s12 center-align">
        {{-- <a href="#!" class="btn">Guardar</a> --}}
        {{-- El resumen debe de activarse hasta que finalice el mantenimiento --}}
        <div class="file-field input-field">
          <div class="btn">
            <span><i class="left material-icons">upload_file</i>Adjuntar</span>
            <input type="file" name="file" id="file">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
        </div>
      </div>
      <div class="col s12 center-align">
        <button class="btn" type="submit" style="width: 100%">
          Guardar 
          <i class="material-icons right">save</i>
        </button>
      </div>
    </div>
  </form>

@else

<form action="{{route('update.dictamen')}}" method="post" id="dictamen" enctype="multipart/form-data">

  @csrf
  <input type="hidden" name="id_equipo" value="{{$data->id_equipo}}">
  <input type="hidden" name="id_ticket" value="{{$data->id_ticket}}">

  <div class="row container">
    <div class="col s12">
      <p>Dictamen</p>
    </div>
    <div class="col s12 center-align">
      {{-- <a href="#!" class="btn">Guardar</a> --}}
      {{-- El resumen debe de activarse hasta que finalice el mantenimiento --}}
      <div class="file-field input-field">
        <div class="btn">
          <span><i class="left material-icons">upload_file</i>Adjuntar</span>
          <input type="file" name="file" id="file" >
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text" value="{{$archivo->nombre}}">
        </div>
      </div>
    </div>
    <div class="col s12 center-align">
      <button class="btn" type="submit" style="width: 100%">
        Actualizar 
        <i class="material-icons right">save</i>
      </button>
    </div>
  </div>
</form>
<div class="row container">
  <div class="col s12">
    <a style="width: 100%" href="{{route('show.dictamen',['name'=>$archivo->nombre,'nombre_hash'=>$archivo->nombre_hash])}}" class="btn" target="_blank">Ver documento</a>
  </div>
</div>
@endempty

{{-- Cada que finaliza, vamos a redirigirlo al form de detalle del equipo--}}
<form action="{{route('equipo.show')}}" id="detalleEquipo">
  <input type="hidden" name="id_equipo" value="{{$data['id_equipo']}}">
  <button type="submit" class="btn" style="display: none"></button>
</form>
@endsection

@push('scripts')
    <script>



        let servicio_actual = @json($data);
        let servicio = @json($servicio);

        if(servicio_actual.id_tecnico_asignado == null){
          console.log('No existe tecnico asignado');
        }
        

        // console.log(servicio);
        // {{--Hay que tener mucho cuidado con lo siguiente. Ya que si cambia el catalog esencialmente, afectara el comportamiento.--}}
        // {{--Por lo que si no coincide algo es por ello y solo es de ajustar las variables.--}}

        servicio_actual.id_tipo_servicio  == 11 && desHabilitar($('#correccion'));
        servicio_actual.id_tipo_servicio  == 12 && desHabilitar($('#mantenimiento'));
        servicio_actual.id_tipo_servicio  == 13 && onlyDictamen($('#mantenimiento'),$('#correccion'));

        servicio_actual.fecha_inicio  != null && desHabilitarBtn($('#mantenimiento .btns_time a.green'));
        servicio_actual.fecha_inicio  != null && desHabilitarBtn($('#correccion .btns_time a.green'));
        servicio_actual.fecha_finalizacion  != null && desHabilitarBtn($('#correccion .btns_time a.red'));
        servicio_actual.fecha_finalizacion  != null && desHabilitarBtn($('#mantenimiento .btns_time a.red'));

          
      cargar_resumenes(servicio)

      function cargar_resumenes(servicio){
        servicio.map((elem)=>{
          if(elem.hasOwnProperty('resumen')){
            switch (elem.id_tipo_servicio) {
              case "11":
                  $('#resumen_mantenimiento').val(elem.resumen);
                break;
              case "12":
                  $('#resumen_correccion').val(elem.resumen);
                break;
            
              default:
                break;
            }  
          }
        })
      }

      function desHabilitarBtn(obj){
        obj.addClass('disabled');
      }
      
      function desHabilitar(obj){
        obj.find('div>a').addClass('disabled');
      }

      function onlyDictamen(obj1,obj2){
        obj1.find('div>a').addClass('disabled');
        obj2.find('div>a').addClass('disabled');
      }

      function registraTimeStamp(obj){
        // Capturamos ambos inputs....
        let resumen_mantenimiento = $('#resumen_mantenimiento').val();
        let resumen_correccion = $('#resumen_correccion').val();
        // Desactivamos el boton
        $(obj).addClass('disabled');
        // Mandamos la columna a registrar el timestamp
        let columna_registrar = obj.textContent.split(' ')[0];
        // Mandamos el tipo de servicio
        // let tipo_servicio = $(obj).parent().closest("form")[0].id;
        // Mandamos el id del servicio actual a actualizar.
        let actual = servicio_actual.id_servicio
        
        // Capturamos el valor de nuestro input de resumen.

        $.ajax({
          type: 'get',
          url: "{{route('servicio.update')}}",
          data: {
            columna_registrar,
            // tipo_servicio,
            servicio,
            actual,
            resumen_mantenimiento,
            resumen_correccion
          },
          dataType: "text",
          success: function (response) {
            $('#detalleEquipo').submit();
          },
          error: function (response){
            console.log(response);
          }
        });


      }



    
    </script>
@endpush



