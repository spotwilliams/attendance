<?php

$estados  = \Cat\Repositories\EstadoContratoRepository::getAll();
$multiple = (!isset($multiple) ? '' : $multiple . ' data-actions-box="true"');
$name     = ($multiple !== '') ? 'estado[]' : 'estado';
if (!isset($estado)) {
    $estado = [];
}
if (!$multiple or !isset($estado) or !is_array($estado)) {
    $estado = [$estado];
}
?>

<div class="{{$cols}} form-group @if($errors->has('estado')) has-error @endif">
    <select title="Estados de contrato" {{$multiple}} name="{{$name}}" data-live-search="true">
        @if(!$multiple)
            <option value="-1">...</option>
        @endif
        @foreach ($estados as $t)
            <option value="{{ $t->id }}"
                    @if(isset($estado) and in_array($t->id, $estado)) selected @endif>{{$t->descripcion}}
            </option>
        @endforeach
    </select>
    @if($errors->has('estado'))
        <span class="help-block">{{$errors->first('estado')}}</span>
    @endif
</div>


