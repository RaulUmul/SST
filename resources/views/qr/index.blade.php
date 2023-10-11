@extends('layouts.plantilla')
@section('title','Codigo QR')
@section('content')
    <div class="row container">
        @include('partials.divider')
        @isset($archivo)
                
            @if(!$archivo)
                <div class="col s12 center-align">
                    <p>Aun no se ha generado el codigo QR</p>
                    @auth
                    <a class="btn" href="{{route('qr.create',['ruta'=>url(route('equipo.show')),'id_equipo'=>$id_equipo])}}">Generar codigo QR<i class="material-icons left">qr_code</i></a>
                    @endauth
                </div>
            @else
                {{-- Mostramos el QR --}}
                <div class="col s12 center-align">
                    <div>
                        <p>Codigo QR para su impresion</p>
                    </div>
                    <img src="data:image;base64,{{base64_encode(\Storage::disk('qrcode')->get($archivo->nombre))}}"
                    width="20%"
                    >
                </div>
                <div class="col s12 center-align">
                    <a href="{{route('qr.download',['archivo'=>json_encode($archivo)])}}" class="btn">Imprimir <i class="material-icons left">print</i></a>
                </div>

                
                {{-- Y deberiamos mostrar la opcion de imprimir pero, eso falta con la impresora termica :'( --}}
            @endif
        @endisset

        @isset($qr)
            {{$qr}}
        @endisset


    </div>
@endsection