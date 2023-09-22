@extends('layouts.plantilla')
@section('title','Codigo QR')
@section('content')
    <div class="row container">
        @include('partials.divider')
        @isset($archivo)
            
        @if(!$archivo)
            <div class="col s12 center-align">
                <p>Aun no se ha generado el codigo QR</p>
                <a class="btn" href="{{route('qr.create',['ruta'=>url(route('equipo.show'))])}}">Generar codigo QR<i class="material-icons left">qr_code</i></a>
            </div>
        @else
            {{--  --}}
        @endif
        @endisset

        @isset($qr)
            {{$qr}}
        @endisset


    </div>
@endsection