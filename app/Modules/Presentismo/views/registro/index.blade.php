@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Registro de presentismo</h3>
            </div>
            {!! Form::open(['route' => 'presentismoPrepareListaAgentes', 'class'=>'form-horizontal', 'method' => 'POST', 'files' => true]) !!}

            <div class="box-body">

                <div class="form-group @if($errors->has('base')) has-error @endif">
                    @include('bases.select-sin-btn' ,['label'=> 'Seleccione la base', 'baseSeleccionada' => $baseActual])
                    @if($errors->has('base'))
                        <span class="help-block col-md-offset-3 col-xs-offset-3">{{$errors->first('base')}}</span>
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

