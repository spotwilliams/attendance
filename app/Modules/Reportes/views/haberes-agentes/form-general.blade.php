<?php

$classContainer = 'col-md-6';
$classLabel     = 'col-md-4 col-xs-4';
$classField     = 'col-sm-8 col-xs-8';

$classMultiSelectContainer = 'col-md-6';

$fechaContrato = isset($fechaContrato) ? $fechaContrato : ['desde' => null, 'hasta' => null];
$fechaIngreso  = isset($fechaIngreso) ? $fechaIngreso : ['desde' => null, 'hasta' => null];

?>
{!! Form::open(['route' => 'reportesHaberesAgentesSearch', 'class'=>'form-horizontal', 'method' => 'POST']) !!}
<div class="box-body">


    <div class="{{$classMultiSelectContainer}}">
        @include('common.bases.as-select-sin-btn', ['label' => 'Bases *', 'multiple' => 'multiple', 'baseSeleccionada' => (isset($base)?$base: [])])
    </div>

    <div class="{{$classMultiSelectContainer}}">
        @include('common.turnos.as-select', ['label' => 'Turnos *', 'multiple' => 'multiple', isset($turno)?$turno: []])
    </div>
    <div class="{{$classMultiSelectContainer}}">
        @include('common.periodos.as-select', ['label' => 'Periodos *', 'periodosSeleccionados' => (isset($periodo)?[$periodo]:[-1])])
    </div>
</div>
<div class="box-footer">
    {!! Form::submit('Buscar', ['class' => 'btn btn-primary pull-right']) !!}
    {!! Form::close() !!}
    {{--@if(isset($exportar))--}}
        {{--{!! $exportar !!}--}}
    {{--@endif--}}
</div>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('select')
                .data('actions-box', true)
                .selectpicker({
                });

        })
    </script>
@append
