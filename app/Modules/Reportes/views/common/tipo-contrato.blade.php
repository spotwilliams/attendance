<?php
use Cat\Repositories\TipoContratoRepository;

$tipos    = TipoContratoRepository::getAll();
$cSelected = (isset($tipoContrato) ? $tipoContrato->id : -1);
?>

<select class="form-control" name="tipoContrato" data-live-search="true">
    <option value="-1">Todos</option>
    @foreach ($tipos as $c)
        <option
                value="{{ $c->id }}"
                @if($cSelected == $c->id) selected @endif>
            {{$c->descripcion}}
        </option>
    @endforeach
</select>
