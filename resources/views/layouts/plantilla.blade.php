<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
       {{-- Materialize --}}
       <!-- Compiled and minified CSS -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
       {{-- Material Icons --}}
       <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
       {{--  Style de Datatable--}}
       <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
       <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        @vite(['resources/css/app.css','resources/js/app.js'])
       @stack('styles')
</head>
<body>
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
    @auth
    <header class="navbar-fixed">
        @include('components/navbar')
    </header>
    @endauth
    <main>
      @auth
        @include('components.sidenav')
      @endauth

        @yield('content')
    </main>

    {{-- <!-- Compiled and minified JavaScript --> --}}
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    {{--  Scripts DataTables--}}
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    @stack('scripts')

</body>
</html>