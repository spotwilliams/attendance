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

            {!! Form::open(['route' => 'presentismosInicialMasivoUpload', 'class'=>'form-horizontal', 'method' => 'POST', 'files' => true]) !!}
            {!! Form::hidden('tipo', $tipo->id) !!}
            <div class="box-body">
                <div class="col-md-offset-2 col-md-8">
                    <div class="form-group">
                        <div class="progress-group col-sm-8 col-sm-offset-2">
                            <span class="progress-text">Paso 2</span>
                            <span class="progress-number"><b>2</b>/3</span>

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" style="width: 66%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-xs-3 control-label">Tipo licencia</label>
                        <div class="col-sm-9 col-xs-9">
                            <span class="label label-info">{{$tipo->descripcion}} ({{$tipo->codigo}})</span>
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('archivo')) has-error @endif">
                        <label for="archivo" class="col-sm-3 col-xs-3 control-label">Archivo completo</label>
                        <div class="col-sm-9 col-xs-9">
                            {!! Form::file('archivo', ['class'=>'filestyle' ,'data-buttonName'=>'btn-primary'])!!}
                            @if($errors->has('archivo'))
                                <span class="help-block col-sm-12 col-xs-12">{{$errors->first('archivo')}}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                {!! Form::submit('Subir y procesar', ['class' => 'btn btn-primary pull-right']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection
