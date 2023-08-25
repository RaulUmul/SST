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
       @vite('resources/app.css')
       @vite('resources/app.js')

       <style>
            main, footer {
              padding-left: 300px;
            }
            @media only screen and (max-width : 992px) {
            header, main, footer {
                padding-left: 0;
              }
            }
       </style>
</head>
<body>
    {{-- Plantilla a extender --}}

    <header class="navbar-fixed">
        @include('components/navbar')
    </header>

    <main>
        @include('components/sidenav')
        @yield('content')
    </main>


    @stack('scripts')
    <script>
        
    </script>
</body>
</html>