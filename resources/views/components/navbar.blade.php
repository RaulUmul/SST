<ul id="menu_user" class="dropdown-content blue-grey darken-4">
  <li><a class="white-text" href="{{route('logout')}}">Salir <i class="white-text material-icons left">power_settings_new</i> </a></li>
</ul>
<nav class=" blue-grey darken-4">
    <div class="nav-wrapper" >
      
      <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      <ul id="nav-mobile" class="left hide-on-med-and-down brand-logo center">
        <li><a href="{{route('sistec.index')}}"><i class="left material-icons">home</i>Inicio</a></li>
        <li><a href="{{route('equipo.index')}}"><i class="left material-icons">devices</i>Equipos</a></li>
      </ul>
      <ul class="right">
        <li>
          <a class="dropdown-trigger" href="#!" data-target="menu_user">
            {{ucwords(auth()->user()->nombres)}}
            <i class="material-icons left">person_2</i>
          </a>
        </li>
      </ul>

    </div>
  </nav>

  @push('scripts')
      <script>
        $(".dropdown-trigger").dropdown();
      </script>
  @endpush