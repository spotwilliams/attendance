<?php

$bases    = \Cat\Repositories\BaseRepository::getAll();
$multiple = (!isset($multiple) ? '' : $multiple . ' data-actions-box="true"');
$name     = ($multiple !== '') ? 'base[]' : 'base';
if (!isset($base)) {
    $base = [];
}
if (!$multiple or !isset($base) or !is_array($base)) {
    $base = [$base];
}
?>

<div class="{{$cols}} form-group @if($errors->has('base')) has-error @endif">

    <select  title="Bases" {{$multiple}} name="{{$name}}" data-live-search="true">
        @if(!$multiple)
            <option value="-1">...</option>
        @endif
        @foreach ($bases as $t)
            <option value="{{ $t->id }}"
                    @if(isset($base) and in_array($t->id, $base)) selected @endif>{{$t->nombre}}
            </option>
        @endforeach
    </select>
    @if($errors->has('base'))
        <span class="help-block">{{$errors->first('base')}}</span>
    @endif
</div>


