<?php
use Cat\Repositories\EstadoContratoRepository;

$estados    = EstadoContratoRepository::getAll();
$cSelected = (isset($estadoContrato) ? $estadoContrato->id : -1);
?>

<select class="form-control" name="estadoContrato" data-live-search="true">
    <option value="-1">Todos</option>
    @foreach ($estados as $c)
        <option
                value="{{ $c->id }}"
                @if($cSelected == $c->id) selected @endif>
            {{$c->descripcion}}
        </option>
    @endforeach
</select>
