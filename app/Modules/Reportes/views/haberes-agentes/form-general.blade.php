<?php
$classMultiSelectContainer = 'col-md-4';
?>
{!! Form::open(['route' => 'reportesHaberesAgentesSearch', 'class'=>'form-horizontal', 'method' => 'POST']) !!}

<div class="box-body">
    <div class="row">
        <div class="{{$classMultiSelectContainer}}">
            @include('common.periodos.as-select-v2', ['label'=> 'Periodo/s', 'multiple' => 'multiple'])
        </div>
        <div class="{{$classMultiSelectContainer}}">
            @include('common.bases.as-checkbox', ['label' => 'Bases'])
        </div>
        <div class="{{$classMultiSelectContainer}}">
            @include('common.turnos.as-checkbox', ['label' => 'Turnos'])
        </div>
        <div class="{{$classMultiSelectContainer}}">
            @include('common.funcion.as-checkbox', ['label' => 'Funciones'])
        </div>
        <div class="{{$classMultiSelectContainer}}">
            @include('common.areas.as-checkbox', ['label' => '&Aacute;reas'])
        </div>
    </div>

</div>
<div class="box-footer">
    {!! Form::submit('Buscar', ['class' => 'btn btn-primary pull-right']) !!}

</div>
{!! Form::close() !!}
@if(isset($exportar))
    {!! $exportar !!}
@endif
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('select')
                .data('actions-box', true)
                .selectpicker({});
        })
    </script>
@append
