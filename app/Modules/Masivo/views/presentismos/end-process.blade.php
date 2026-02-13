@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Carga de presentismos masiva</h3>
            </div>

            <div class="box-body">
                <div class="col-md-offset-2 col-md-8">
                    @include('flash::message')
                    <p class="help-block">Por favor revise el archivo generado con las filas que no se pudieron
                        guardar.</p>
                    <div class="row">
                        <div class="col-md-2">
                            {!! Form::open(['route' => 'presentismosMasivoSelectFile', 'method' => 'POST']) !!}

                            <input type="hidden" name="turno" value="{{$turno->id}}">
                            <input type="hidden" name="base" value="{{$base->id}}">
                            <button class="btn btn-default col-sm-offset-2">Atr&aacute;s</button>
                            {!! Form::close() !!}
                        </div>
                        @if(count($messages) > 0)
                            <div class="col-md-4 col-sm-offset-2">
                                <div class="alert alert-warning">
                                    @foreach($messages as $message)
                                        {{$message}}
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
