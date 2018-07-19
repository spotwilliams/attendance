<?php
$selected = isset($periodo) ? $periodo : [];
$periodos = \Cat\Models\Periodo::select(['*'])
    ->whereDate('fecha_comienzo', '<=', new DateTime('now'))
    ->orderBy('fecha_comienzo', 'DESC')
    ->get();
$multiple = (!isset($multiple) ? '' : $multiple);
$name = ($multiple !== '') ? 'periodo[]' : 'periodo';
?>


<div class="form-group @if($errors->has('periodo')) has-error @endif">
    <label class="col-sm-3 col-xs-3 control-label">
        @if(isset($label))
            {{$label}}
        @else
            Seleccione el periodo
        @endif
    </label>
    <div class="col-sm-9 col-xs-9">
        <select class="form-control" {{$multiple}} name="{{$name}}" data-live-search="true">
            @foreach ($periodos as $periodo)
                <?php

                $mesFacturacion = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_fin);
                $mesFacturacion->addMonth(1);

                $start = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_comienzo);
                $end = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_fin);
                ?>
                <option value="{{$periodo->id}}"
                        @if(in_array($periodo->id, $selected)) selected @endif
                >{{trans('month.'.$mesFacturacion->format('m'))}}
                    '{{$mesFacturacion->format('y')}} ({{$start->format('d/m/Y')}} - {{$end->format('d/m/Y')}})
                </option>
            @endforeach
        </select>
        @if($errors->has('periodo'))
            <span class="help-block">{{$errors->first('periodo')}}</span>
        @endif
    </div>
</div>






