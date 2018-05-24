<?php

$tipos    = \Cat\Repositories\TipoContratoRepository::getAll();
$multiple = (!isset($multiple) ? '' : $multiple . ' data-actions-box="true"');
$name     = ($multiple !== '') ? 'tipo[]' : 'tipo';
if (!isset($tipo)) {
    $tipo = [];
}
if (!$multiple or !isset($tipo) or !is_array($tipo)) {
    $tipo = [$tipo];
}
?>

<div class="{{$cols}} form-group @if($errors->has('tipo')) has-error @endif">
    <select class="" title="Tipos de contrato" {{$multiple}} name="{{$name}}" data-live-search="true">
        @if(!$multiple)
            <option value="-1">...</option>
        @endif
        @foreach ($tipos as $t)
            <option value="{{ $t->id }}"
                    @if(isset($tipo) and in_array($t->id, $tipo)) selected @endif>{{$t->descripcion}}
            </option>
        @endforeach
    </select>
    @if($errors->has('tipo'))
        <span class="help-block">{{$errors->first('tipo')}}</span>
    @endif
</div>


