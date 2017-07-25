<?php
use Cat\Repositories\TurnosRepository;

$turnos = TurnosRepository::getAll();

$classContainer = 'col-md-4';
$classLabel = 'col-md-3 col-xs-3';
$classField = 'col-sm-9 col-xs-9';
?>
{!! Form::open(['route' => 'reportesPresentismoGeneralSearch', 'class'=>'form-horizontal', 'method' => 'POST']) !!}
<div class="box-body">

    <div class="{{$classContainer}}">
        <div class="form-group">
            <label class="{{$classLabel}} control-label">Rango de fechas</label>
            <div class="{{$classField}}">
                @include('Reportes::common.dates')
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
