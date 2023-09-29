@extends('layouts.plantilla')
@section('title','Administracion de usuarios')
@section('content')
    {{-- Traemos todos los usuarios, pero solo mostramos id, cui y nombres, obviamente al seleccionarlos --}}
    {{-- Debera traernos sus atributos. --}}


    {{-- Mejor brindamos un input que cuando se consulte al usuario nos traiga la informacion. --}}
    <div class="row">
        <div class="col s12">
            <p>Consulte usuario para <strong class="blue-text"> asignar / editar / eliminar </strong> Roles</p>
        </div>
        <div class="col s12">
            <form action="" id="formConsulta">
                <div class="input-field col s12">
                    <input id="cui" type="text" class="validate">
                    <label for="cui">DPI</label>
                </div>
            </form>
        </div>
        <div class="col s12">
            <button class="btn" style="width: 100%" id="buscarUsuario">
                Buscar
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col s12 center-align">
            {{-- Aqui se renderizara los roles que tiene actualmente el usuario. --}}
            <form action="{{route('update.roles')}}" method="POST">
                @csrf
                <div class="col s12">

                    <input type="hidden" name="id_usuario" id="id_usuario">

                    <p><strong>Tecnico administrador</strong></p>
                    <p>Activo</p>
                    <p>
                        <label>
                          <input id="yesadmon" name="administrador" type="radio" value="on" />
                          <span>Si</span>
                        </label>
                        <label>
                          <input id="noadmon" name="administrador" type="radio" value="off"/>
                          <span>No</span>
                        </label>
                    </p>
                </div>
                @include('partials.divider')
                <div class="col s12">
                    <p><strong>Tecnico</strong></p>
                    <p>Activo</p>
                    <p>
                        <label>
                          <input id="yestecnico" name="operador" type="radio" value="on"/>
                          <span>Si</span>
                        </label>
                        <label>
                          <input id="notecnico" name="operador" type="radio" value="off"/>
                          <span>No</span>
                        </label>
                    </p>
                </div>
                <button id="enviarRoles" class="btn disabled" type="submit" style="width: 100%">
                    Actualizar 
                    <i class="material-icons right">save</i>
                </button>
            </form>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            
            $('#buscarUsuario').on('click',function(){

                let cui = $('#cui').val();

                $.ajax({
                    type: "get",
                    url: "{{route('usuario.search')}}",
                    data: {
                        cui
                    },
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        $('#enviarRoles').removeClass('disabled');
                        $('#notecnico').attr('checked','checked')
                        $('#noadmon').attr('checked','checked')
                        
                            if(response.usuario.roles != null){
                                JSON.parse(response.usuario.roles).map((rol)=>{
                                    switch (rol) {
                                        case 2:
                                            $('#yesadmon').attr('checked','checked');
                                            break;
                                        case 3:
                                            $('#yestecnico').attr('checked','checked');
                                            break;
                                    
                                        default:
                                            break;
                                    }
                                });
                            }
                        $('#id_usuario').val(response.usuario.id_usuario);
                        
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

            });

        });
    </script>
@endpush