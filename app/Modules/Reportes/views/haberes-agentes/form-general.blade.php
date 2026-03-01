<?php
$classMultiSelectContainer = 'col-md-6';
?>
<form action="{{ route('reportesHaberesAgentesSearch') }}" method="POST" class="form-horizontal">@csrf

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
    <button type="submit" class="btn btn-primary pull-right">Buscar</button>

</div>
</form>
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
