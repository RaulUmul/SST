@extends('layouts.plantilla')
@section('title','Detalle Servicios')
@section('content')

{{-- Un formulario para capturar el inicio y la finalizacion --}}
 
{{-- Vamos a crear 3 formularios --}}
{{-- Y solo vamos a sustituir segun venga los arreglos de servicio y servicio_actual --}}
{{-- A jugar con los gatos pes T.T --}}
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
        <input id="resumen_mantenimiento" type="text" name="resumen_mantenimiento">
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
    <div class="col s12 center-align">
      <a href="#!" onclick="registraTimeStamp(this)" class="green btn">Iniciar <i class="left material-icons">play_circle</i></a>
      <a href="#!" onclick="registraTimeStamp(this)" class="red btn">Finalizar <i class="left material-icons">stop_circle</i></a>
      {{-- El resumen debe de activarse hasta que finalice el mantenimiento --}}
      <div class="input-field col s12">
        <input id="resumen_correccion" type="text" name="resumen_correccion">
        <label for="resumen_correccion">Resumen/Observacion</label>
      </div>
    </div>
    @include('partials.divider')
  </div>
</form>
{{-- Form Dictamen --}}
<form action="" id="dictamen">
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
          <input type="file">
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text">
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
    <script>

      let servicio_actual = @json($data);
      let servicio = @json($servicio);
      if(servicio_actual.id_tecnico_asignado == null){
        console.log('No existe tecnico asignado');
      }

      console.log(servicio_actual);

      // Hay que tener mucho cuidado con lo siguiente. Ya que si cambia el catalog esencialmente, afectara el comportamiento.
      // Por lo que si no coincide algo es por ello y solo es de ajustar las variables.

      servicio_actual.id_tipo_servicio  == 11 && desHabilitar($('#correccion'));
      servicio_actual.id_tipo_servicio  == 12 && desHabilitar($('#mantenimiento'));
      servicio_actual.id_tipo_servicio  == 13 && onlyDictamen($('#mantenimiento'),$('#correccion'));

      servicio_actual.fecha_inicio  != null && desHabilitarBtn($('#mantenimiento .btns_time a.green'));

      function desHabilitarBtn(obj){
        console.log(obj);
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
        // Desactivamos el boton
        $(obj).addClass('disabled');
        // Mandamos la columna a registrar el timestamp
        let columna_registrar = obj.textContent.split(' ')[0];
        // Mandamos el tipo de servicio
        // let tipo_servicio = $(obj).parent().closest("form")[0].id;
        // Mandamos el id del servicio actual a actualizar.
        let actual = servicio_actual.id_servicio
        
        $.ajax({
          type: 'get',
          url: "{{route('servicio.update')}}",
          data: {
            columna_registrar,
            // tipo_servicio,
            servicio,
            actual
          },
          dataType: "json",
          success: function (response) {
            console.log(response);
            // servicio_actual.id_tipo_servicio  == 11 && desHabilitar($('#correccion'));
            // servicio_actual.id_tipo_servicio  == 12 && desHabilitar($('#mantenimiento'));
            // servicio_actual.id_tipo_servicio  == 13 && onlyDictamen($('#mantenimiento'),$('#correccion'));
            window.history.go(-1);

            window.history.back();
          },
          error: function (response){
            console.log(response);
          }
        });


      }
      // console.log(servicio_actual.id_servicio);
      // Quien es el servicio actual? Y su estado... 
      // Segun eso deshabilitaremos el resto.
      // Dictamen al guardar, se deshabilitaran el resto..
      // Por eso es importante verificar si el servicio actual es dictamen, proceder a deshabilitar el resto.
      // if(@json($data))
    </script>
@endpush



