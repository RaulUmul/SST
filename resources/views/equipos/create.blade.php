@extends('layouts.plantilla')
@section('title','Ingreso de equipo')
@section('content')
    <div class="row">
        {{-- Titulo --}}
        <div class="col s12">
            <h2 class="center-align">Ingresar Equipo</h2>
        </div>

        <div class="col s12">
            <div class="divider"></div>
        </div>

        {{-- Tecnicos Revisa / Asigna --}}
        <div class="col s12">
            <div class="input-field col s6">
                <select id="tecnico_revisa">
                  <option value="" disabled selected>Choose your option</option>
                  <option value="1">Admin 1</option>
                  <option value="2">Tecnico 1</option>
                  <option value="3">Tecnico 2</option>
                </select>
                <label>Tecnico que revisa</label>
            </div>
            <div class="input-field col s6">
                <select id="tecnico_asignado">
                  <option value="" disabled selected>Choose your option</option>
                </select>
                <label>Tecnico a asignar</label>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>

    // Supongamos que recibo un array con los values;

    let tecnicos = ['Alexander','Fernando','Carlos','Werner'];

    let instance_tecnico_revisa = document.getElementById('tecnico_revisa');
    var instance_tecnico_asignado = document.getElementById('tecnico_asignado');
    instance_tecnico_asignado.value = "Oye3";
    M.FormSelect.init(instance_tecnico_revisa);

    instance_tecnico_asignado.value = 'Hi';

    M.FormSelect.init(instance_tecnico_asignado);

</script>
@endpush