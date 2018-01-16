@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h3 class="box-title">Carga de agentes masiva</h3>
    </section>
    <div class="content">

        <div class="clearfix"></div>
        <div class="box box-danger">

            <div class="box-body">
                @include('flash::message')
                <p class="help-block">Por favor revise el archivo generado con las filas que no se pudieron guardar.</p>
                {!! Form::open(['route' => 'agentesMasivoDuplicadoDownload', 'method' => 'POST']) !!}

                {!! Form::hidden('file', session('agentes_new_file')) !!}

                <a class="btn btn-default pull-left" href="{{URL::previous()}}"><i class="fa fa-arrow-left"></i>Volver</a>
                {!! Form::submit('Descargar archivo de errores', ['class' => 'btn btn-primary pull-right']) !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

