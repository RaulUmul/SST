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
       <!-- Compiled and minified JavaScript -->
       <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
       @vite(['resources/css/app.css','resources/js/app.js'])
       @stack('styles')
</head>
<body>
    {{-- Plantilla a extender --}}

    <header class="navbar-fixed">
        @include('components/navbar')
    </header>

    <main>
        @include('components.sidenav')
        @yield('content')
    </main>


    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    @stack('scripts')

    <script>
        
    </script>
</body>
</html>