<?php
use Cat\Repositories\CargoRepository;

$cargos    = CargoRepository::getAll();
$cSelected = (isset($cargo) ? $cargo->id : -1);
?>

<select class="form-control" name="cargo" data-live-search="true">
    <option value="-1">Todos</option>
    @foreach ($cargos as $c)
        <option
                value="{{ $c->id }}"
                @if($cSelected == $c->id) selected @endif>
            {{$c->nombre}}
        </option>
    @endforeach
</select>
