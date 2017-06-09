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
            {!! Form::open(['route' => 'haberesPrepareListaAgentes', 'class'=>'form-horizontal', 'method' => 'POST', 'files' => true]) !!}

            <div class="box-body">

                <div class="form-group @if($errors->has('base')) has-error @endif">
                    @include('bases.select-sin-btn' ,['routeName'=>'presentismoIndex', 'label'=> 'Seleccione la base', 'baseSeleccionada' => $baseActual])
                    @if($errors->has('base'))
                        <span class="help-block">{{$errors->first('base')}}</span>
                    @endif
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

