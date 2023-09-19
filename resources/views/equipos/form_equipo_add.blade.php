<tr data-index="{{$index}}">
  <input type="hidden" name="equipo_{{$index}}[tipo_equipo]" value="{{$tipo_equipo}}">
  <input type="hidden" name="equipo_{{$index}}[numero_serie]" value="{{$numero_serie}}">
  <input type="hidden" name="equipo_{{$index}}[marca]" value="{{$marca}}">
  <input type="hidden" name="equipo_{{$index}}[accesorios]" value="{{$accesorios}}">
  <td>{{$tipo_equipo}}</td>
  <td>{{$numero_serie}}</td>
  <td>{{$marca}}</td>
  <td>{{$accesorios}}</td> 
  <td><a class="btn" onclick="eliminar_equipo(this)"><i class="material-icons">delete</i></a></td>
</tr>
  