<?php
use Cat\Repositories\PeriodoRepository;

$estadoPeriodos = PeriodoRepository::getPeriodosActivosParaBaseAndTurno($base, $turno);

?>
@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">C&aacute;lculo de haberes</h3>
            </div>
            {!! Form::open(['route' => 'haberesPrepareListaAgentes', 'class'=>'form-horizontal', 'method' => 'POST']) !!}

            {!! Form::hidden('base', $base->id) !!}
            {!! Form::hidden('turno', $turno->id) !!}
            <div class="box-body">
                <div class="col-md-offset-2 col-md-8">

                    <div class="form-group">
                        <div class="progress-group">
                            <span class="progress-text">Paso 2</span>
                            <span class="progress-number"><b>2</b>/4</span>

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" style="width: 50%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-3 control-label">Base seleccionada</label>
                        <div class="col-sm-9 col-xs-9">
                            <span class="label label-info">{{$base->nombre}}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-3 control-label">Turno seleccionado</label>
                        <div class="col-sm-9 col-xs-9">
                            <span class="label label-info">{{$turno->codigo}}</span>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('periodo')) has-error @endif">
                        <label class="col-sm-3 col-xs-3 control-label">Seleccione el periodo</label>
                        <div class="col-sm-9 col-xs-9">
                            <select class="form-control" name="periodo">
                                <option value="-1">...</option>
                                @foreach ($estadoPeriodos as $estado)
                                    <option value="{{ $estado->id_periodo }}">
                                        Del {{(new DateTime($estado->periodo->fecha_comienzo))->format('d/m/Y')}}
                                        hasta {{(new DateTime($estado->periodo->fecha_fin))->format('d/m/Y')}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('periodo'))
                                <span class="help-block">{{$errors->first('periodo')}}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                {!! Form::submit('Siguiente', ['class' => 'btn btn-primary pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $('select').attr('data-live-search', true).selectpicker({});
        })
    </script>
@append

