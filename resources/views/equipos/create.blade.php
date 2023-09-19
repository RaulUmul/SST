@extends('layouts.plantilla')
@section('title', 'Ingreso de equipo')
@section('content')
    <div class="row container">
        {{-- Titulo --}}
        <div class="col s12">
            <h2 class="center-align">INGRESAR EQUIPO</h2>
        </div>
        @include('partials.divider')
        <form action="{{route('equipo.store')}}" method="POST" id="formIngresoEquipo">
            @method('post')
            @csrf
            {{-- Tecnicos Revisa / Asigna --}}
            <div class="col s12">
                <div class="input-field col s12 m6">
                    <i class="material-icons prefix">person_outline</i>
                    <select id="tecnico_revisa">
                        <option value="" disabled selected>Selecciona</option>
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
                        <li class="tab col s6"><a class="active" href="#tabAddArma" style="color: #263238"> Agregar Equipos</a>
                        </li>
                        <li class="tab col s6"><a href="#tabListArma" style="color: #263238"> Lista de agregados : <strong id="total_equipos">0</strong> </a></li>
                    </ul>
                </div>
                {{-- Tab Agregar Equipos --}}
                <div id="tabAddArma" class="col s12">
                    {{-- Numero de ticket --}}
                    <div class="row">
                        <div class="col s12 m6 labelMod ">
                            <label for="numero_ticket">Ticket No.</label>
                        </div>
                        <div class="input-field col s12 m6 right-align">
                            30199
                            <input id="numero_ticket" name="numero_ticket" type="hidden" class="validate" value="30199">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 labelMod hide-on-small-only">
                            <label for="tipo_equipo">Tipo de equipo</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <i class="material-icons prefix">scanner</i>
                            <select id="tipo_equipo">
                                <option value="{{null}}" selected>Selecciona</option>
                                @foreach ($tipo_equipo as $key => $value)
                                <option value="{{$value->id_item}}" >{{$value->descripcion}}</option>
                                @endforeach
                            </select>
                            <label>Tipo de equipo</label>
                        </div>
                    </div>
                    {{-- Numero de serie --}}
                    <div class="row">
                        <div class="col s12 m6 labelMod hide-on-small-only">
                            <label for="numero_serie">Numero serie</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="numero_serie"  type="text" class="validate" placeholder="Numero de serie">
                            <label for="numero_serie" class="hide-on-med-and-up">Numero Serie</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 labelMod hide-on-small-only">
                            <label for="marca">Marca</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="marca" type="text" name="marca" type="text" class="validate" placeholder="Marca equipo">
                            <label for="marca" class="hide-on-med-and-up">Marca</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6 labelMod hide-on-small-only">
                            <label for="accesorios">Accesorios</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="accesorios" type="text" name="accesorios" type="text" class="validate" placeholder="Accesorios">
                            <label for="accesorios" class="hide-on-med-and-up">Accesorios</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 right-align">
                            <a href="#!" class="btn" id="agregar_equipo"><i class="right material-icons">add</i>Agregar</a>
                        </div>
                    </div>

                    
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
                <div id="tabListArma" class="col s12">
                    <div class="row">
                        <table class="striped">
                            <thead>
                                <tr>
                                    <th>Tipo equipo</th>
                                    <th>Numero serie</th>
                                    <th>Marca</th>
                                    <th>Accesorios</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @include('partials.divider')

            <div class="row">
                <div class="col s12 m6 labelMod hide-on-small-only">
                    <label for="nip_usuario">NIP</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="nip_usuario" type="text" name="nip_usuario" type="text" class="validate" placeholder="Ingrese NIP">
                    <label for="nip_usuario" class="hide-on-med-and-up">NIP</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 labelMod hide-on-small-only">
                    <label for="dependencia_policial">Dependencia Policial</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="dependencia_policial" type="text" name="dependencia_policial" type="text" class="validate" placeholder="Dependencia Policial">
                    <label for="dependencia_policial" class="hide-on-med-and-up">Dependencia Policial</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 labelMod hide-on-small-only">
                    <label for="fecha_ingreso">Fecha de Ingreso</label>
                </div>
                <div class="input-field col s12 m6">
                        <input type="date" class="datepicker" id="fecha_ingreso" name="fecha_ingreso" value="{{date('Y-m-d')}}">
                    <label for="fecha_ingreso" class="hide-on-med-and-up">Fecha de Ingreso</label>
                </div>
            </div>
            @include('partials.divider')
            {{-- Servicios a realizar a equipos --}}
            <div class="row">
                <div class="col s12 center-align">
                    <h4>SERVICIOS A REALIZAR</h4>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m4 center-align">
                    <label>
                        <input type="checkbox" name="mantenimiento" id="mantenimientoBox" value="{{$mantenimiento}}"/>
                        <span>Mantenimiento</span>
                    </label>
                </div>
                <div class="col s12 m4 center-align">
                    <label>
                        <input type="checkbox" name="correccion" id="correccionBox" value="{{$correccion}}"/>
                        <span>Correción</span>
                    </label>
                </div>
                <div class="col s12 m4 center-align">
                    <label>
                        <input type="checkbox" name="dictamen" id="dictamenBox" value="{{$dictamen}}"/>
                        <span>Dictamen</span>
                    </label>
                </div>
            </div>
            @include('partials.divider')
            <div class="row">
                <div class="col s12 center-align">
                    <button class="btn" type="submit" id="enviarForm">Ingresar</button>
                </div>
            </div>
            {{-- Fin Servicios a realizar --}}
        </form>
    </div>
@endsection

@push('scripts')
    @include('equipos.js.create')
@endpush
