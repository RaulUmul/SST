<ul id="slide-out" class="sidenav sidenav-fixed">
   <li>
        <div class="center">
           <span> SISTEC </span>
        </div>
        <div class="user-view center">
            {{-- <div class="background">
                <img src="images/office.jpg">
            </div> --}}
            {{-- <a href="#user"><img class="circle" src="images/yuna.jpg"></a> --}}
            <a href="#" ><i class="material-icons large">face</i></a>
            <a href="#"><span class="black-text name">USUARIO</span></a>
            {{-- <a href="#email"><span class="white-text email">jdandturk@gmail.com</span></a> --}}
        </div>
    </li>
    <div class="divider"></div>
    <li><a href="#!"><i class="material-icons">home</i>Inicio</a></li>
    <li><a href="#!"><i class="material-icons">devices</i>Equipos</a></li>
    <li>
    <div class="divider"></div>
    </li>
    {{-- <li><a class="subheader">Subheader</a></li> --}}
    <li class="row">
        <div class="col s6">
            <strong>Equipos Recientes</strong>
        </div>
        <div class="col s6">
            <a class="btn-small" href="{{route('equipo.create')}}">
                <i class="material-icons tiny right">add</i>
                Ingresa
            </a>
        </div>
    </li>
    {{-- Input de busqueda de equipos, parametros: S/N - Tipo - Marca --}}
    <li class="row">
        <div class="col s12">
            <form action="">
                <div class="input-field col s12">
                    <input id="parametro" type="text" class="validate">
                    <label for="parametro">Buscar Equipo...</label>
                  </div>
            </form>
        </div>
    </li>
</ul>


@push('scripts')
    <script>

    </script>
@endpush
