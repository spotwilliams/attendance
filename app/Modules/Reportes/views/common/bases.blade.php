<?php
$bases            = \Cat\Repositories\BaseRepository::getAll();
$baseSeleccionada = (isset($base) ? $base->id : -1);
?>

<select class="form-control" name="base" data-live-search="true">
    <option value="-1">Todas</option>
    @foreach ($bases as $base)
        <option value="{{ $base->id }}" {{($baseSeleccionada == $base->id) ? 'selected': ''}}>{!! $base->nombre !!}</option>
    @endforeach
</select>
