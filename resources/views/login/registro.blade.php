<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro - SISTEC</title>
       {{-- Materialize --}}
       <!-- Compiled and minified CSS -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
       {{-- Material Icons --}}
       <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
       {{--  Style de Datatable--}}
       <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
        @vite(['resources/css/app.css','resources/js/app.js'])
       @stack('styles')


       <style>
        body{
            background-color: azure;
        }
       </style>
</head>
<body class="blue-grey darken-4">
    {{-- Plantilla a extender --}}

    @if (session('success'))
        <div id="modal_success" class="modal">
          <div class="modal-content center">
            <h4>{{ session('success') }}</h4>
          </div>
          <div class="modal-footer">
            <div class="col s12" style="display: flex; justify-content: space-around;">
                <a  class="waves-light btn modal-close">
                  Aceptar
                  <i class="large material-icons right">check</i>
                </a>
            </div>
          </div>
        </div>
        @push('scripts')
          <script>
              $('.modal').modal();
              $('#modal_success').modal('open');
          </script>
        @endpush
    @endif

    @if (session('error'))
        <div id="modal_error" class="modal">
          <div class="modal-content center">
            <h4>{{ session('error') }}</h4>
          </div>
          <div class="modal-footer">
            <div class="col s12" style="display: flex; justify-content: space-around;">
                <a  class="waves-light btn modal-close">
                  Aceptar
                  <i class="large material-icons right">check</i>
                </a>
            </div>
          </div>
        </div>
        @push('scripts')
          <script>
              $('.modal').modal();
              $('#modal_error').modal('open');
          </script>
        @endpush
    @endif     


    <div class="container" style="min-height: 100vh; display: flex;justify-content: center; align-items: center">
        <div class="contenedor" style="background-color: white;padding:50px; border-radius: 4px ; border: 1px solid black;display: flex; flex-direction: column">
            <div class="logotipo center-align" style="">
                <img src="https://sistemas.pnc.gob.gt/sispe/images/logoPNC.png" alt=""
                height="125px">
                <img src="" alt="">
            </div>
            <div class="lema center-align">
                <strong>Bienvenido a Sistema de Servicios Tecnicos</strong>
            </div>
            <div class="inputs">
                <form  method="POST" action="{{route('registro.create')}}">
                    @csrf
                    <div class="row">
                        <div class="col s12 center-align red-text">
                            @error('usuario')
                                {{$message}}
                            @enderror
                        </div>
                    </div>
                    <div class="row">

                        <div class="input-field col s12">
                            <input name="nombres" id="nombres" type="text" class="validate" value="{{old('nombres')}}">
                            <label for="nombres">Nombre completo</label>
                            <span class="helper-text red-text">{{$errors->first('nombres')}}</span>
                        </div>
                        <div class="input-field col s12">
                            <input name="apellidos" id="apellidos" type="text" class="validate" value="{{old('apellidos')}}">
                            <label for="apellidos">Apellidos</label>
                            <span class="helper-text red-text">{{$errors->first('apellidos')}}</span>
                        </div>
                        <div class="input-field col s12">
                            <input name="cui"  id="cui" type="text" class="validate" value="{{old('cui')}}">
                            <label for="cui">DPI / CUI</label>
                            <span class="helper-text red-text">{{$errors->first('cui')}}</span>
                        </div>
                        <div class="input-field col s12">
                            <input name="password" id="password" type="password" class="validate">
                            <label for="password">Contraseña</label>
                            <span class="helper-text red-text">{{$errors->first('password')}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 center-align">
                            <button class="btn">
                                Registrarse
                                <i class="material-icons right">check</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="registro center-align">
                Si ya tienes cuenta inicia sesion <a href="{{route('login.index')}}">aqui</a>
            </div>
        </div>
    </div>

    {{-- <!-- Compiled and minified JavaScript --> --}}
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    {{--  Scripts DataTables--}}
    @stack('scripts')
</body>
</html>