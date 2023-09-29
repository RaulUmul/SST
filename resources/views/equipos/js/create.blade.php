<script>
//{{-- Inicio de elementos Materialize / Variables --}}

//{{--Validara si hay suficiente equipos para hacer el envio del formulario--}}
let equipos_en_lista = 0;

let tecnico_revisaS = document.getElementById('tecnico_revisa');
M.FormSelect.init(tecnico_revisaS);

let tecnico_asignadoS = document.getElementById('tecnico_asignado');
M.FormSelect.init(tecnico_asignadoS);

let tipo_equipo = document.getElementById('tipo_equipo');
M.FormSelect.init(tipo_equipo);

        {{--tecnicos.map((tecnico) => {
            let option = document.createElement("option", );
            option.value = tecnico;
            option.text = tecnico;
            tecnico_asignado.append(option);
        })--}}

//{{--Declaracion de funciones--}}

function agregar_equipo(){
  let numero_serie = $('#numero_serie').val();
  let marca = $('#marca').val();
  let accesorios = $('#accesorios').val();
  let tipo_equipo = $('#tipo_equipo').val();
  let index = 0;
  let dataIndex = $('#tabListArma>.row>table>tbody>tr:last').data('index');

  // {{--Capturamos el valor del ultimo index y le sumamos 1 al index a enviar.--}}
  if(dataIndex != null) index = dataIndex+1; 

  $.ajax({
      url: '{{route('equipo.add')}}',
      type: 'post',
      data: {
        _token:'{{ csrf_token() }}', 
        tipo_equipo,
        numero_serie,
        marca,
        accesorios,
        index
      },
      dataType: 'text',
      success: function (response){
          // Traemos ya el renderizado de los datos. Y solo realizamos un append.
          $('#tabListArma>.row>table>tbody').append(response);
          M.toast({html: '<span><i class="material-icons left">check</i></span><span>Equipo agregado</span>'});
          updateNumeroLista();
          limpiarEntradas();
      },
      error : function(response, status) {
        if(JSON.parse(response.responseText)){
          let errores = Object.values(JSON.parse(response.responseText));
          errores.map(el => {
            M.toast({html: `<span><i class="material-icons left">error</i></span><span>${el}</span>`});
            }
          )
        }
      },
      complete : function(xhr, status) {
      console.log('Petición realizada');
      }
  })
}

function limpiarEntradas(){
  $('#tipo_equipo').val("");
  $('#tipo_equipo').val("").trigger('change');
  $('#numero_serie').val('');
  $('#marca').val('');
  $('#accesorios').val('');
  M.updateTextFields();
}

let eliminar_equipo = (obj) =>{
  $(obj).parent().closest("tr").remove();
  updateNumeroLista();
}

let updateNumeroLista=()=> {
  let cant = $('#tabListArma>.row>table>tbody').find('tr').length;
  $('#total_equipos').text(cant);
  equipos_en_lista = cant;
}

//{{-- Llamadas a funciones --}}

$('#agregar_equipo').on('click',function(){
  agregar_equipo();
});

$('#enviarForm').on('click',function (e) {
  e.preventDefault()

  let tecnico_revisa = $('#tecnico_revisa').val(),
      tecnico_asignado = $('#tecnico_asignado').val(),
        nip_usuario = $('#nip_usuario').val(),
        dependencia_policial = $('#dependencia_policial').val(),
        servicios_a_realizar = $('input:checked').length;

        // console.log(tecnico_revisa);
        // return;

    $.ajax({
    url: '{{route('equipo.store')}}',
      type: 'post',
      data: {
        _token:'{{ csrf_token() }}',
        tecnico_revisa,
        tecnico_asignado,
        nip_usuario,
        dependencia_policial,
        equipos_en_lista,
        servicios_a_realizar,
        default0:0,
      }}).done(function (response){
        $('#formIngresoEquipo').submit();
      }).fail(function (response){
        if(JSON.parse(response.responseText)){
          let errores = Object.values(JSON.parse(response.responseText));
          errores.map(el => {
            M.toast({html: `<span><i class="material-icons left">error</i></span><span>${el}</span>`});
            }
          )
        }
      });

})

</script>
