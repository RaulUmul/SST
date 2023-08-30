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
            <a href="{{route('equipo.create')}}" class="btn btn-small"><i class="right material-icons">add</i>Ingresar</a>
        </div>
    </div>
    <div class="col s12">
    <div class="divider"></div>
    </div>
    {{-- Tabla de Los equipos en cola.... --}}
    <div class="col s12">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae nisi natus velit animi amet voluptatum nam, corrupti dolor vero at porro accusantium laboriosam officia cupiditate sed magni dolorem ipsam est?
    </div>

</div>
@endsection








