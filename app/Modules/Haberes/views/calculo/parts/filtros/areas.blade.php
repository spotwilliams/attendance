<?php

$areas    = \Cat\Repositories\AreaRepository::getAll();
$multiple = (!isset($multiple) ? '' : $multiple . ' data-actions-box="true"');
$name     = ($multiple !== '') ? 'area[]' : 'area';
if (!isset($area)) {
    $area = [];
}
if (!$multiple or !isset($area) or !is_array($area)) {
    $area = [$area];
}
?>

<div class="{{$cols}} form-group @if($errors->has('area')) has-error @endif">

    <select title="&Aacute;reas" {{$multiple}} name="{{$name}}" data-live-search="true">
        @if(!$multiple)
            <option value="-1">...</option>
        @endif
        @foreach ($areas as $t)
            <option value="{{ $t->id }}"
                    @if(isset($area) and in_array($t->id, $area)) selected @endif>{{$t->nombre}}
            </option>
        @endforeach
    </select>
    @if($errors->has('area'))
        <span class="help-block">{{$errors->first('area')}}</span>
    @endif
</div>


