@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h3 class="box-title">Carga de agentes masiva</h3>
    </section>
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header with-border">
            </div>
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'presentismosMasivoUpload', 'method' => 'POST', 'files' => true]) !!}
                    @include('bases.select-sin-btn' , ['routeName'=>'agentesIndex', 'label'=> 'Seleccione la base', 'baseSeleccionada' => $baseActual])
                    <div class="col-sm-offset-1 col-sm-11">

                        <div class="form-group @if($errors->has('archivo')) has-error @endif">
                            <label for="archivo" class="col-sm-2">Seleccione el archivo</label>
                            {{--<input type="file" id="archivo" name="archivo" class="col-sm-6">--}}
                            {!! Form::file('archivo')!!}
                            @if($errors->has('archivo'))
                                <span class="help-block col-sm-12">{{$errors->first('archivo')}}</span>
                            @endif

                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                {!! Form::submit('Subir y procesar', ['class' => 'btn btn-primary']) !!}
                                <p class="help-block">Ingrese un archivo CSV acorde al formato permitido. <a
                                            href="#">Ver archivo ejemplo</a></p>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
@endsection

