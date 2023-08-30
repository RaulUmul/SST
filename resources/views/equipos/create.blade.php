@extends('layouts.plantilla')
@section('title','Ingreso de equipo')
@section('content')
    <div class="row container">
        {{-- Titulo --}}
        <div class="col s12">
            <h2 class="center-align">Ingresar Equipo</h2>
        </div>
        @include('partials.divider')
        <form action="">    
            {{-- Tecnicos Revisa / Asigna --}}
            <div class="col s12">
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">person_outline</i>
                    <select id="tecnico_revisa">
                    <option value="" disabled selected>Selecciona</option>
                    <option value="1">Admin 1</option>
                    <option value="2">Tecnico 1</option>
                    <option value="3">Tecnico 2</option>
                    </select>
                    <label for="tecnico_revisa">Tecnico que revisa</label>
                </div>
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">person_outline</i>
                    <select id="tecnico_asignado" class="materialSelect">
                    <option value="" disabled selected>Selecciona</option>
                    </select>
                    <label>Tecnico a asignar</label>
                </div>
            </div>

            @include('partials.divider')



            {{-- TAB de Informacion de Equipo en Ticket --}}

            <div class="row">
                <div class="col s12">
                    <ul class="tabs blue-grey lighten-5">
                        <li class="tab col s6"><a class="active" href="#test1" style="color: #263238"> Agregar Equipos</a></li>
                        <li class="tab col s6"><a href="#test2" style="color: #263238"> Lista de agregados</a></li>
                    </ul>
                </div>
                {{-- Tab Agregar Equipos --}}
                <div id="test1" class="col s12">
                    {{-- Numero de ticket --}}
                    <div class="row">
                        <div class="col s12 m6 labelMod ">
                            <label for="numero_ticket">Ticket No.</label>
                        </div>
                        <div class="input-field col s12 m6">
                            30199
                            <input id="numero_ticket" name="numero_ticket" type="hidden" class="validate" value="30199">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 labelMod hide-on-small-only">
                            <label for="numero_serie">Numero serie</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="numero_serie" name="numero_serie" type="text" class="validate" placeholder="Numero de serie">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 labelMod hide-on-small-only">
                            <label for="marca">Marca</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="marca" type="text" name="marca" type="text" class="validate" placeholder="Marca equipo">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 labelMod hide-on-small-only">
                            <label for="accesorios">Accesorios</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="accesorios" type="text" name="accesorios" type="text" class="validate" placeholder="Accesorios">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 right-align">
                            <a href="#!" class="btn"><i class="right material-icons">add</i>Agregar</a>
                        </div>
                    </div>
                    {{-- Numero de serie --}}
    
                    {{-- <div class="input-field col s6">
                        <i class="material-icons prefix">person_outline</i>
                        <select id="numero_ticket">
                        <option value="" disabled selected>Selecciona</option>
                        <option value="1">Admin 1</option>
                        <option value="2">Tecnico 1</option>
                        <option value="3">Tecnico 2</option>
                        </select>
                        <label for="tecnico_revisa">Tecnico que revisa</label>
                    </div> --}}

                </div>
                {{-- Tab Lista de agregados --}}
                <div id="test2" class="col s12">

                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>

    // Supongamos que recibo un array con los values; En una variable de PHP desde el controlador

    let tecnicos = ['Alexander','Fernando','Carlos','Werner'];
    let tecnico_revisa = document.getElementById('tecnico_revisa');
    let tecnico_asignado = document.getElementById('tecnico_asignado');
    M.FormSelect.init(tecnico_revisa);
    M.FormSelect.init(tecnico_asignado);
    tecnicos.map((tecnico)=>{
            let option = document.createElement("option",);
            option.value = tecnico;
            option.text = tecnico;
            console.log(option);
            tecnico_asignado.append(option);
        });
    M.FormSelect.init(tecnico_asignado);

</script>
@endpush