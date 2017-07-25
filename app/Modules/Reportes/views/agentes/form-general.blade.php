<?php
use Cat\Repositories\TurnosRepository;

$turnos = TurnosRepository::getAll();

$classContainer = 'col-md-4';
$classLabel = 'col-md-4 col-xs-4';
$classField = 'col-sm-8 col-xs-8';
?>
{!! Form::open(['route' => 'reportesAgentesGeneralSearch', 'class'=>'form-horizontal', 'method' => 'POST']) !!}
<div class="box-body">

    <div class="{{$classContainer}}">
        <div class="form-group">
            <label class="{{$classLabel}} control-label">Fecha contrato</label>
            <div class="{{$classField}}">
                @include('Reportes::common.dates-single', ['nombreCampo' => 'fechaContrato'])
                <p class="help-block">Se mostrar&aacute; hasta esta fecha</p>
            </div>
        </div>
    </div>
    <div class="{{$classContainer}}">
        <div class="form-group">
            <label class="{{$classLabel}} control-label">Base</label>
            <div class="{{$classField}}">
                @include('Reportes::common.bases')
            </div>
        </div>
    </div>
    <div class="{{$classContainer}}">
        <div class="form-group">
            <label class="{{$classLabel}} control-label">Turno</label>
            <div class="{{$classField}}">
                @include('Reportes::common.turnos')
            </div>
        </div>
    </div>
    <div class="{{$classContainer}}">
        <div class="form-group">
            <label class="{{$classLabel}} control-label">Cargo</label>
            <div class="{{$classField}}">
                @include('Reportes::common.cargos')
            </div>
        </div>
    </div>
    <div class="{{$classContainer}}">
        <div class="form-group">
            <label class="{{$classLabel}} control-label">Funci&oacute;n</label>
            <div class="{{$classField}}">
                @include('Reportes::common.funcion')
            </div>
        </div>
    </div>
    <div class="{{$classContainer}}">
        <div class="form-group">
            <label class="{{$classLabel}} control-label">Tipos contrato</label>
            <div class="{{$classField}}">
                @include('Reportes::common.tipo-contrato')
            </div>
        </div>
    </div>
    <div class="{{$classContainer}}">
        <div class="form-group">
            <label class="{{$classLabel}} control-label">Estado</label>
            <div class="{{$classField}}">
                @include('Reportes::common.estado-contrato')
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-12 col-xs-12">
        <div class="form-group">
            <label class="col-md-1 control-label pull-left">&Aacute;rea</label>
            <div class="col-md-11">
                @include('Reportes::common.areas')
            </div>
        </div>
    </div>
</div>
<div class="box-footer">
    {!! Form::submit('Buscar', ['class' => 'btn btn-primary pull-right']) !!}
</div>
{!! Form::close() !!}
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('select').selectpicker({});
        })
    </script>
@append
