@extends('layouts.plantilla')

@section('content')

<div class="row">
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
  <div class="col s12 m6">
    <canvas id="myChartTrabajados"></canvas>
  </div>
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
      myChart.destroy();
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
              data: [{x: 'Febrero',y:20},{x: 'Marzo',y:61}]
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

