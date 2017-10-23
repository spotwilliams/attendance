<?php
$bases    = \Cat\Models\Base::all();
$multiple = (!isset($multiple) ? '' : $multiple);
$name     = ($multiple !== '') ? 'base[]' : 'base';

if (!$multiple or !is_array($baseSeleccionada)) {
    $baseSeleccionada = [$baseSeleccionada];
}
?>

<div class="form-group @if($errors->has('base')) has-error @endif">
    <label class="col-sm-3 col-xs-3 control-label">{{$label}}</label>
    <div class="col-sm-9 col-xs-9">
        <select class="form-control" id="base-select-sin-btn" {{$multiple}} name="{{$name}}" data-live-search="true">
            @if(!$multiple)
                <option value="-1">...</option>
            @endif
            @foreach ($bases as $base)
                <option value="{{ $base->id }}" {{in_array($base->id, $baseSeleccionada) ? 'selected': ''}}>{!! $base->nombre !!}</option>
            @endforeach
        </select>
        @if($errors->has('base'))
            <span class="help-block col-sm-12 col-xs-12">{{$errors->first('base')}}</span>
        @endif
    </div>

</div>

