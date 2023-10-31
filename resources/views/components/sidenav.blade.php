<ul id="slide-out" class="sidenav sidenav-fixed @yield('ocultar')">
    <div class="contenedor-sidenav">

        <li>
            <div class="center">
                <span> SISTEC </span>
            </div>
            <div class="user-view center" style="height: 75px">
                <div class="background">
                    <img src="{{asset('img/sgtic.webp')}}" type="image/webp"
                    height="50px"
                    > {{--Momentaneamente--}}
                </div>
                {{-- <a href="#user"><img class="circle" src="images/yuna.jpg"></a> --}}
                {{-- <a href="#"><i class="material-icons large">face</i></a> --}}
                {{-- <a href="#"><span class="black-text name">USUARIO</span></a> --}}
                {{-- <a href="#email"><span class="white-text email">jdandturk@gmail.com</span></a> --}}
            </div>
        </li>
        <div class="divider modDivider"></div>
        <li class="hide-on-large-only"><a href="{{route('sistec.index')}}"><i class="material-icons">home</i>Inicio</a></li>
        <li class="hide-on-large-only"><a href="{{route('equipo.index')}}"><i class="material-icons">devices</i>Equipos</a></li>
        {{-- Aqui entrar un middleware para mostrar/ocultar el acceso --}}
        <li class=""><a href="{{route('usuario.index')}}"><i class="material-icons">manage_accounts</i>Administracion de Usuarios</a></li>
        <li class=""><a href="{{route('reportes.index')}}"><i class="material-icons">summarize</i>Reportes</a></li>
        {{-- Termina la autorizacion --}}
        <li class="hide-on-large-only">
            <div class="divider modDivider"></div>
        </li>
        <li class="row center">
            <div class="col s12">
                <a href="{{route('qr.search')}}" class="btn"><i class="left material-icons">qr_code</i>Busqueda por QR</a>
            </div>
        </li>
        {{-- <li><a class="subheader">Subheader</a></li> --}}
        <li class="row">
            <div class="col s6">
                <p style="padding: 0; margin-top:2px">
                    <strong>Ingresar equipo</strong>
                </p>
            </div>
            <div class="col s6">
                <a class="btn-small" href="{{ route('equipo.create') }}">
                    <i class="material-icons tiny right">add</i>
                    Nuevo
                </a>
            </div>
        </li>
        {{-- Input de busqueda de equipos, parametros: S/N - Tipo - Marca --}}
        <li class="row">
            <div class="col s12">
                <form action="">
                    <div class="input-field col s12">
                        <input id="parametro" type="text" class="validate">
                        <label for="parametro">Buscar equipo por No. Serie</label>
                    </div>
                </form>
            </div>
        </li>
        <li class="row">
            <div class="col s12">
                <table id="table-equipos-sidenav">
                    <thead>
                    <tr>
                      <th>Tipo</th>
                      <th>Serie</th>
                      <th>Acciones</th>
                    </tr>
                    </thead>
                  </table>
            </div>
        </li>

    </div>
</ul>


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
            // console.log(resp.equipos);
            var tablaEquipoSidenav = $('#table-equipos-sidenav').addClass('nowrap').DataTable({
                // responsive: true,
                "drawCallback": function( settings ) {
                    $('#table-equipos-sidenav thead').remove();
                },
                "pageLength": 3,
                // "order": [ 0, 'desc' ],
                data: resp.equipos,
                columns: [
                {data: 'id_tipo_equipo',render: function(data){
                    let descripcion;
                    resp.tipo_equipo.map((tipo)=>{
                        if(data === tipo.id_item){descripcion = `${tipo.descripcion}`};
                    });
                    return descripcion;
                }}, // {{--Tipo--}}
                {data: 'numero_serie'}, // {{--Serie--}}
                {data: null}, //Acciones
                ],
                // select: true,
                dom: '',
                responsive: true,
                columnDefs:[
                    {target: 1 ,responsivePriority: 1},
                    // {target: 3 ,responsivePriority: 2},
                {
                    target: -1,
                    responsivePriority: 0,
                    visible: true,
                    data: 'id_equipo',
                    orderable: false,
                    render: function ( data, type, row, meta ) {
                    
                    return  `
                    <form action="{{route('equipo.show')}}">
                    <input type="hidden" name="id_equipo" value="${data.id_equipo}">
                    <button type="submit" class="btn"> <i class="tiny material-icons">visibility</i></button>
                    </form>
                    `;
                    }
                }
                ],
                // "bDestroy": true
            });

            // $('#asignados_me').on('click',function (event){
            //     // console.log();
            //     tablaArmas.columns(1).search($(this).data('key')).draw(); // Columna 8 -> registro arma
            // });

            // $('#allEquipos').on('click',function(){
            //     tablaArmas.columns().search('').draw();            
            // });

            $('#parametro').on('keyup',function (){
                tablaEquipoSidenav.columns(1).search(this.value).draw(); // Columna 8 -> registro arma
            });

            },
            error: function (response){
            console.log(response)
            },
        });
        });
    </script>
@endpush
