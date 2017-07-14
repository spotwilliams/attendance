<?php
use Cat\Repositories\TipoPresentismosRepository;

$turnos = TipoPresentismosRepository::getAll();
?>
@extends('layouts.app')


@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Carga inicial</h3>
            </div>

            {!! Form::open(['route' => 'presentismosInicialMasivoSelectFile', 'class'=>'form-horizontal', 'method' => 'POST', 'files' => true]) !!}
            <div class="box-body">
                <div class="col-md-offset-2 col-md-8">
                    <div class="form-group">
                        <div class="progress-group col-sm-8 col-sm-offset-2">
                            <span class="progress-text">Paso 1</span>
                            <span class="progress-number"><b>1</b>/3</span>
                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" style="width: 33%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-3 control-label">Seleccione el tipo de licencia</label>
                        <div class="col-sm-9 col-xs-9">
                            <select class="form-control" name="tipo" data-live-search="true">
                                <option value="-1">...</option>
                                @foreach ($turnos as $t)
                                    <option value="{{ $t->id }}">
                                        {{$t->descripcion}} ({{$t->codigo}})
                                    </option>
                                @endforeach
                            </select>

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
            $('select').selectpicker({});
        })
    </script>
@append
