@extends('layouts.plantilla')
@section('title','Tickets anteriores')
@section('content')
    <div class="row container">
        <div class="col s12">
            <ul class="collection with-header">
                <li class="collection-header"><h4>Tickets</h4></li>
                {{-- @dd($id_equipo) --}}
                @foreach (json_decode($tickets) as $ticket)
                <li class="collection-item">
                    <div>No. {{$ticket->id_ticket}}
                        <a href="{{route('equipo.show_especifically',['id_ticket'=>$ticket->id_ticket,'id_equipo'=>$id_equipo])}}" class="secondary-content" onclick=""><i class="material-icons">send</i>
                        </a>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection