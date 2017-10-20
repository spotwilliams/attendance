<?php

$funciones = \Cat\Models\TipoPresentismo::all();
$multiple = (!isset($multiple) ? '' : $multiple);
$name     = ($multiple !== '') ? 'tipo_presentismo[]' : 'tipo_presentismo';
?>

<div class="form-group @if($errors->has('tipo_presentismo')) has-error @endif">
    <label class="col-sm-3 col-xs-3 control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione una funci&oacute;n
        @endif
    </label>
    <div class="col-sm-9 col-xs-9">
        <select class="form-control" {{$multiple}} name="{{$name}}" data-live-search="true">
            <option value="-1">...</option>
            @foreach ($funciones->groupBy('aplica') as $tipo => $grupo)
                <optgroup label="{{trans('aplica.'.$tipo)}}">
                    @foreach($grupo as $tp)
                        <option value="{{$tp->id }}"
                                data-content="<span class='label' style='color: {{$tp->color_letra}}; background-color: {{$tp->color}}'>{{$tp->descripcion}} ({{$tp->codigo}})</span>"
                                @if(isset($tiposPresentismos) and in_array($tp->id, $tiposPresentismos)) selected @endif>{{$tp->codigo}}
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        @if($errors->has('tipo_presentismo'))
            <span class="help-block">{{$errors->first('tipo_presentismo')}}</span>
        @endif
    </div>
</div>


