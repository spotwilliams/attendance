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
            {!! Form::open(['route' => 'haberesSelectPeriodo', 'class'=>'form-horizontal', 'method' => 'POST', 'files' => true]) !!}

            <div class="box-body">
                <div class="form-group">
                    <div class="progress-group col-sm-8 col-sm-offset-2">
                        <span class="progress-text">Paso 1</span>
                        <span class="progress-number"><b>1</b>/3</span>

                        <div class="progress">
                            <div class="progress-bar progress-bar-yellow" style="width: 33%"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group @if($errors->has('base')) has-error @endif">
                    @include('bases.select-sin-btn' ,[ 'label'=> 'Seleccione la base', 'baseSeleccionada' => $baseActual])
                    @if($errors->has('base'))
                        <span class="help-block">{{$errors->first('base')}}</span>
                    @endif
                </div>


            </div>
            <div class="box-footer">
                {!! Form::submit('Siguiente', ['class' => 'btn btn-primary pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

