<?php
use Cat\Repositories\TurnosRepository;


$classContainer            = 'col-md-6 col-lg-6 col-xs-6';
$classLabel                = 'col-md-3 col-xs-3';
$classField                = 'col-sm-9 col-xs-9';
$classMultiSelectContainer = 'col-md-6 col-lg-6 col-xs-6';

?>
{!! Form::open(['route' => 'reportesPresentismoGeneralSearch', 'class'=>'form-horizontal', 'method' => 'POST']) !!}
<div class="box-body">

    <div class="{{$classContainer}}">
        <div class="form-group">
            <label class="{{$classLabel}} control-label">Rango de fechas</label>
            <div class="{{$classField}}">
                @include('Reportes::common.dates-range', ['nombreCampo' => 'rango'])
            </div>
        </div>
    </div>
    <div class="{{$classContainer}}">
        <div class="form-group">
            <label class="{{$classLabel}} control-label">Incluir comentarios</label>
            <div class="{{$classField}}">
                <div class="checkbox checkbox-info checkbox-circle">
                    <input type="checkbox" value="true" id="incluir_comentario" name="incluir_comentario" @if(isset($incluir_comentarios) and ($incluir_comentarios == true)) checked @endif>
                    <label for="incluir_comentario">
                        Si
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="{{$classMultiSelectContainer}}">
        @include('common.bases.as-checkbox', ['label' => 'Bases'])
    </div>
    <div class="{{$classContainer}}">
        <div class="form-group">
            <label class="{{$classLabel}} control-label">Incluir sin presentismos</label>
            <div class="{{$classField}}">
                <div class="checkbox checkbox-info checkbox-circle">
                    <input type="checkbox" value="true" id="incluir_sin_presentismo" name="incluir_sin_presentismo" @if(isset($incluir_sin_presentismo) and ($incluir_sin_presentismo == true)) checked @endif>
                    <label for="incluir_sin_presentismo">
                        Si
                    </label>
                </div>
            </div>
        </div>
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
    <div class="{{$classMultiSelectContainer}}">
        @include('common.estado-contratos.as-checkbox', ['label' => 'Estado contrato'])
    </div>
    <div class="{{$classMultiSelectContainer}}">
        @include('common.tipo-contratos.as-checkbox', ['label' => 'Tipo contrato'])
    </div>
    <div class="{{$classMultiSelectContainer}}">
        @include('common.tipo-presentismos.as-select', ['label' => 'Tipo licencia', 'multiple' => 'multiple'])
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
