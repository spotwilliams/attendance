<?php

$classContainer = 'col-md-4';
$classLabel     = 'col-md-4 col-xs-4';
$classField     = 'col-sm-8 col-xs-8';

$classMultiSelectContainer = 'col-md-6 col-lg-6 col-xs-6';
?>
{!! Form::open(['route' => 'reportesAgentesGeneralSearch', 'class'=>'form-horizontal', 'method' => 'POST']) !!}
<div class="box-body">

    <div class="{{$classContainer}}">
        <div class="form-group">
            <label class="{{$classLabel}} control-label">Fecha contrato</label>
            <div class="{{$classField}}">
                @include('Reportes::common.dates-range', ['nombreCampo' => 'fecha_contrato'])
            </div>
        </div>
    </div>
    <div class="{{$classContainer}}">
        <div class="form-group">
            <label class="{{$classLabel}} control-label">Fecha ingreso</label>
            <div class="{{$classField}}">
                @include('Reportes::common.dates-range', ['nombreCampo' => 'fecha_ingreso'])
            </div>
        </div>

    </div>

    <div class="{{$classContainer}}">
        <div class="form-group">
            <label class="{{$classLabel}} control-label">Sexo</label>
            <div class="{{$classField}}">
                <select name="sexo">
                    <option value="-1">Todos</option>
                    <option value="F">Mujer</option>
                    <option value="H">Hombre</option>
                </select>
            </div>
        </div>
    </div>

    <div class="{{$classMultiSelectContainer}}">
        @include('common.bases.as-checkbox', ['label' => 'Bases'])
    </div>
    <div class="{{$classMultiSelectContainer}}">
        @include('common.areas.as-checkbox', ['label' => '&Aacute;reas'])
    </div>
    <div class="{{$classMultiSelectContainer}}">
        @include('common.cargos.as-checkbox', ['label' => 'Cargos'])
    </div>

    <div class="{{$classMultiSelectContainer}}">
        @include('common.turnos.as-checkbox', ['label' => 'Turnos'])
    </div>
    <div class="{{$classMultiSelectContainer}}">
        @include('common.funcion.as-checkbox', ['label' => 'Funciones'])
    </div>
    <div class="{{$classMultiSelectContainer}}">
        @include('common.gerencias.as-checkbox', ['label' => 'Gerencias'])
    </div>
    <div class="{{$classMultiSelectContainer}}">
        @include('common.tipo-contratos.as-checkbox', ['label' => 'Tipo contrato'])
    </div>
    <div class="{{$classMultiSelectContainer}}">
        @include('common.estado-contratos.as-checkbox', ['label' => 'Estado contrato'])
    </div>
    <div class="{{$classMultiSelectContainer}}">
        @include('common.iibb.as-checkbox', ['label' => 'Tipo de inscripci&oacute;n IIBB'])
    </div>
    <div class="{{$classMultiSelectContainer}}">
        @include('common.estudios.nivel-as-checkbox', ['label' => 'Nivel de estudio'])
    </div>
    <div class="{{$classMultiSelectContainer}}">
        @include('common.estudios.estado-as-checkbox', ['label' => 'Estado de estudio'])
    </div>
</div>
<div class="box-footer">
    {!! Form::submit('Buscar', ['class' => 'btn btn-primary pull-right']) !!}
{!! Form::close() !!}
    @if(isset($exportar))
        {!! $exportar !!}
    @endif
</div>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('select').selectpicker({});
        })
    </script>
@append
