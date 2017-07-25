<?php
use Cat\Repositories\FuncionRepository;

$funciones    = FuncionRepository::getAll();
$cSelected = (isset($funcion) ? $funcion->id : -1);
?>

<select class="form-control" name="funcion" data-live-search="true">
    <option value="-1">Todos</option>
    @foreach ($funciones as $c)
        <option
                value="{{ $c->id }}"
                @if($cSelected == $c->id) selected @endif>
            {{$c->nombre}}
        </option>
    @endforeach
</select>
