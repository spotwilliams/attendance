<?php

$turnos   = \Cat\Repositories\TurnosRepository::getAll();
$multiple = (!isset($multiple) ? '' : $multiple . ' data-actions-box="true"');
$name     = ($multiple !== '') ? 'turno[]' : 'turno';
if (!isset($turno)) {
    $turno = [];
}
if (!$multiple or !isset($turno) or !is_array($turno)) {
    $turno = [$turno];
}
?>

<div class="{{$cols}} form-group @if($errors->has('turno')) has-error @endif">
    <select class="" title="Turnos" {{$multiple}} name="{{$name}}" data-live-search="true">
        @if(!$multiple)
            <option value="-1">...</option>
        @endif
        @foreach ($turnos as $t)
            <option value="{{ $t->id }}"
                    @if(isset($turno) and in_array($t->id, $turno)) selected @endif>{{$t->codigo}}
            </option>
        @endforeach
    </select>
    @if($errors->has('turno'))
        <span class="help-block">{{$errors->first('turno')}}</span>
    @endif
</div>


