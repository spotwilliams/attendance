<?php
use Cat\Repositories\TurnosRepository;

$turnos = TurnosRepository::getAll();
?>
@extends('layouts.app')


@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Carga de presentismos masiva</h3>
            </div>

            <form action="{{ route('presentismosMasivoSelectFile') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">@csrf
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
                    @include('common.bases.as-select-sin-btn' , ['routeName'=>'agentesIndex', 'label'=> 'Seleccione la base', 'baseSeleccionada' => -1])
                    <div class="form-group @if($errors->has('turno')) has-error @endif">
                        <label class="col-sm-3 col-xs-3 control-label">Seleccione el turno</label>
                        <div class="col-sm-9 col-xs-9">
                            <select class="form-control" name="turno" data-live-search="true">
                                <option value="-1">...</option>
                                @foreach ($turnos as $t)
                                    <option value="{{ $t->id }}">{{$t->codigo}}
                                        {{--({{$t->descripcion}})--}}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('turno'))
                                <span class="help-block">{{$errors->first('turno')}}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                {{--<p class="help-block pull-left">Ingrese un archivo CSV acorde al formato permitido.--}}
                {{--<a class="btn btn-default btn-xs">Ver instrucciones</a>--}}
                {{--</p>--}}
                <button type="submit" class="btn btn-primary pull-right">Siguiente</button>
            </div>
            </form>
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
