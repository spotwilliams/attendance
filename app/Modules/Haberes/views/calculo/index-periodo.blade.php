<?php
use Cat\Repositories\PeriodoRepository;

$periodos = PeriodoRepository::getPeriodosActivosParaBase($baseActual);
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

            {!! Form::hidden('base', $baseActual) !!}
            <div class="box-body">
                <div class="form-group">
                    <div class="progress-group col-sm-8 col-sm-offset-2">
                        <span class="progress-text">Paso 2</span>
                        <span class="progress-number"><b>2</b>/3</span>

                        <div class="progress">
                            <div class="progress-bar progress-bar-yellow" style="width: 66%"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group @if($errors->has('periodo')) has-error @endif">
                    <label class="col-sm-3 col-xs-3 control-label">Seleccione el periodo a calcular</label>
                    <div class="col-sm-9 col-xs-9">
                        <select class="form-control" name="periodo">
                            <option value="-1">...</option>
                            @foreach ($periodos as $periodo)
                                <option value="{{ $periodo->id }}">
                                    Del {{(new DateTime($periodo->fecha_comienzo))->format('d/m/Y')}}
                                    hasta {{(new DateTime($periodo->fecha_fin))->format('d/m/Y')}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('periodo'))
                            <span class="help-block">{{$errors->first('periodo')}}</span>
                        @endif
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

