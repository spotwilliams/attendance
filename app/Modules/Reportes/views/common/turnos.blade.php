<?php
use Cat\Repositories\TurnosRepository;

$turnos    = TurnosRepository::getAll();
$tSelected = (isset($turno) ? $turno->id : -1);
?>

<select class="form-control" name="turno" data-live-search="true">
    <option value="-1">Todos</option>
    @foreach ($turnos as $t)
        <option value="{{ $t->id }}" @if($tSelected == $t->id) selected @endif>{{$t->codigo}}
        </option>
    @endforeach
</select>
