@extends('layouts.plantilla')

@section('content')

<div class="row">
  {{-- PROMEDIO --}}
  <div class="col s12 m6">
    <canvas id="myChartPromedio"></canvas>
    <div class="input-field col s12">
      <select id="tecnico_promedio">
        <option value="{{null}}" disabled selected>Tecnico</option>
        @foreach ($tecnicos as $key => $value)
        <option value="{{$value->id_usuario}}">{{$value->nombres.' '.$value->apellidos}}</option>
        @endforeach
      </select>
      <label>Filtrar por Tecnico</label>
    </div>
  </div>
  {{-- TRABAJOS REALIZADOS --}}
  <div class="col s12 m6">
    <canvas id="myChartTrabajados"></canvas>
    <div class="input-field col s12 m6 l4">
      <select id="anio">
        <option value="{{null}}" disabled>Año</option>
        <option value="2023"" selected>2023</option>
      </select>
      <label>Año</label>
    </div>
    <div class="input-field col s12 m6 l4">
      <select id="fecha_inicio">
        <option value="{{null}}" disabled selected>Fecha inicio</option>
        <option value="01">Enero</option>
        <option value="02">Febrero</option>
        <option value="03">Marzo</option>
        <option value="04">Abril</option>
        <option value="05">Mayo</option>
        <option value="06">Junio</option>
        <option value="07">Julio</option>
        <option value="08">Agosto</option>
        <option value="09">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>
      </select>
      <label>Fecha inicio</label>
    </div>
    <div class="input-field col s12 m6 l4">
      <select id="fecha_fin">
        <option value="{{null}}" disabled selected>Fecha final</option>
        <option value="01">Enero</option>
        <option value="02">Febrero</option>
        <option value="03">Marzo</option>
        <option value="04">Abril</option>
        <option value="05">Mayo</option>
        <option value="06">Junio</option>
        <option value="07">Julio</option>
        <option value="08">Agosto</option>
        <option value="09">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>
      </select>
      <label>Fecha fin</label>
    </div>
    <div class="input-field col s12">
      <select id="tecnico_trabajo">
        <option value="{{null}}" disabled selected>Tecnico</option>
        @foreach ($tecnicos as $key => $value)
        <option value="{{$value->id_usuario}}">{{$value->nombres.' '.$value->apellidos}}</option>
        @endforeach
      </select>
      <label>Filtrar por Tecnico</label>
    </div>
  </div>
</div>

<div class="row">

</div>

@endsection

@push('scripts')
<script>
    $('select').formSelect();
    let myChartPromedio;
    let myChartTrabajados;
    const ctx = document.getElementById('myChartPromedio');
    const ctx_trabajados = document.getElementById('myChartTrabajados');

    // Seccion de Consulta de datos.

    $.ajax({
        type: 'get',
        url: "{{route('reporte.servicioPromedio')}}",
        data: null, //Aqui enviamos segun el select
        dataType: 'text',
        success: function (response) {
            // Correctivo
            console.log((JSON.parse(response)).correctivos);
            let correctivos = (JSON.parse(response)).correctivos;
            let segundos_correctivos = 0;
            let promedio_minutos_correctivo = 0;
            let total_segundos_correctivo = 0;
            // Preventivo
            let preventivos = (JSON.parse(response)).preventivos;
            let segundos_preventivos = 0;
            let total_segundos_preventivos = 0;
            let promedio_minutos_preventivos = 0;

            correctivos.forEach(element => {
                segundos_correctivos += Math.abs(Math.floor(Date.parse(element.fecha_inicio) / 1000) - Math.floor(Date.parse(element.fecha_finalizacion) / 1000));
            });
            total_segundos_correctivo = (Math.abs(segundos_correctivos)/60); //Pasado a minutos
            promedio_minutos_correctivo = total_segundos_correctivo / correctivos.length; 

            preventivos.forEach(element => {
                segundos_preventivos += Math.abs(Math.floor(Date.parse(element.fecha_inicio) / 1000) - Math.floor(Date.parse(element.fecha_finalizacion) / 1000));
            });
            total_segundos_preventivos = (Math.abs(segundos_preventivos)/60); //Pasado a minutos
            promedio_minutos_preventivos = total_segundos_preventivos / preventivos.length;

            console.log('Minutos_correctivo',promedio_minutos_correctivo);
            console.log('Minutos_preventivos',promedio_minutos_preventivos);

            mantenimientoPromedio(promedio_minutos_preventivos,promedio_minutos_correctivo);
        }
    });

    $('#tecnico_promedio').on('change',function(){
      let tecnico = $(this).val();
      myChartPromedio.destroy();
      $.ajax({
        type: 'get',
        url: "{{route('reporte.servicioPromedio')}}",
        data: {tecnico}, //Aqui enviamos segun el select
        dataType: 'text',
        success: function (response) {
            // Correctivo
            console.log((JSON.parse(response)).correctivos);
            let correctivos = (JSON.parse(response)).correctivos;
            let segundos_correctivos = 0;
            let promedio_minutos_correctivo = 0;
            let total_segundos_correctivo = 0;
            // Preventivo
            let preventivos = (JSON.parse(response)).preventivos;
            let segundos_preventivos = 0;
            let total_segundos_preventivos = 0;
            let promedio_minutos_preventivos = 0;

            correctivos.forEach(element => {
                segundos_correctivos += Math.abs(Math.floor(Date.parse(element.fecha_inicio) / 1000) - Math.floor(Date.parse(element.fecha_finalizacion) / 1000));
            });
            total_segundos_correctivo = (Math.abs(segundos_correctivos)/60); //Pasado a minutos
            promedio_minutos_correctivo = total_segundos_correctivo / correctivos.length; 

            preventivos.forEach(element => {
                segundos_preventivos += Math.abs(Math.floor(Date.parse(element.fecha_inicio) / 1000) - Math.floor(Date.parse(element.fecha_finalizacion) / 1000));
            });
            total_segundos_preventivos = (Math.abs(segundos_preventivos)/60); //Pasado a minutos
            promedio_minutos_preventivos = total_segundos_preventivos / preventivos.length;

            console.log('Minutos_correctivo',promedio_minutos_correctivo);
            console.log('Minutos_preventivos',promedio_minutos_preventivos);

            mantenimientoPromedio(promedio_minutos_preventivos,promedio_minutos_correctivo);
        }
      });
    })


    $('#fecha_inicio').on('change',function(){
      let fecha_inicio = $(this).val();
      let fecha_final = $('#fecha_fin').val();
      myChartTrabajados.destroy();
      $.ajax({
        type: 'get',
        url: "{{route('reporte.totalTrabajados')}}",
        data: {fecha_inicio,fecha_final}, //Aqui enviamos segun el select
        dataType: 'text',
        success: function (response) {
          // Llamamos a la funcion totalTrabajados
          console.log(response);
        }
      });
    })

    $('#fecha_fin').on('change',function(){
      let fecha_inicio = $('#fecha_inicio').val();
      let fecha_final = $(this).val();
      myChartTrabajados.destroy();
      $.ajax({
        type: 'get',
        url: "{{route('reporte.totalTrabajados')}}",
        data: {fecha_inicio,fecha_final}, //Aqui enviamos segun el select
        dataType: 'text',
        success: function (response) {
          // Llamamos a la funcion totalTrabajados
          console.log(response);
        }
      });
    })



    // Esto estara en una funcion que renderizara cada que lo invoquen con los datos necesarios. 

    function mantenimientoPromedio(promPreventivo,promCorrectivo){
       myChartPromedio =  new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Preventivo','Correctivo'], //Etiquetas (de cada columna)
            datasets: [{
              label: 'Tiempo promedio (Minutos) por Servicio',
              data: [promPreventivo,promCorrectivo], //La data la insertamos en un arreglo
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
    }

   totalTrabajados()
    function totalTrabajados(){
      myChartTrabajados = new Chart(ctx_trabajados,{
        type: 'line',
        data:{
          labels: ['Enero','Febrero','Marzo'],
          datasets: [{
              label: 'General',
              data: [{x:'Enero',y:20},{x: 'Enero',y:20},{x: 'Marzo',y:61}]
            }]
          },
        options: {
          scales: {
              y: {
                beginAtZero: true
              }
            },
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
            title: {
              display: true,
              text: 'Servicios realizados'
            }
          }
        },
      })
    }
  </script>
@endpush

