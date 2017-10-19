<?php

$periodos = \Cat\Models\Periodo::select(['*'])->orderBy('id', 'DESC')->get();
$multiple = (!isset($multiple) ? '' : $multiple);
$name     = ($multiple !== '') ? 'periodo[]' : 'periodo';
?>

<div class="form-group @if($errors->has('periodo')) has-error @endif">
    <label class="col-sm-3 col-xs-3 control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione el/los peri&oacute;dos
        @endif
    </label>
    <div class="col-sm-9 col-xs-9">
        <select class="form-control" {{$multiple}} name="{{$name}}" data-live-search="true">
            @foreach ($periodos as $p)
                <option value="{{ $p->id }}"
                        @if(isset($periodosSeleccionados) and (in_array($p->id, $periodosSeleccionados))) selected @endif>
                    {{(new DateTime($p->fecha_comienzo))->format('d/m/Y')}}
                    hasta {{(new DateTime($p->fecha_fin))->format('d/m/Y')}}
                </option>
            @endforeach
        </select>
        @if($errors->has('periodo'))
            <span class="help-block">{{$errors->first('periodo')}}</span>
        @endif
    </div>
</div>


