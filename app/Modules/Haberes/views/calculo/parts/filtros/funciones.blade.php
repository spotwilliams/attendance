<?php

$funcions = \Cat\Repositories\FuncionRepository::getAll();
$multiple = (!isset($multiple) ? '' : $multiple . ' data-actions-box="true"');
$name = ($multiple !== '') ? 'funcion[]' : 'funcion';
if (!isset($funcion)) {
    $funcion = [];
}
if (!$multiple or !isset($funcion) or !is_array($funcion)) {
    $funcion = [$funcion];
}
?>

<div class=" {{$cols}} form-group @if($errors->has('funcion')) has-error @endif">

    <select class="" title="Funciones" {{$multiple}} name="{{$name}}" data-live-search="true">
        @if(!$multiple)
            <option value="-1">...</option>
        @endif
        @foreach ($funcions as $t)
            <option value="{{ $t->id }}"
                    @if(isset($funcion) and in_array($t->id, $funcion)) selected @endif>{{$t->nombre}}
            </option>
        @endforeach
    </select>
    @if($errors->has('funcion'))
        <span class="help-block">{{$errors->first('funcion')}}</span>
    @endif
</div>


