@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h3 class="box-title">Carga de agentes masiva</h3>
    </section>
    <div class="content">

        <div class="clearfix"></div>
        <div class="box box-warning">

            <div class="box-body">
                @include('flash::message')
                <p class="help-block">Por favor revise el archivo generado con las filas que no se pudieron guardar.</p>
                {!! Form::open(['route' => 'agentesMasivoDownload', 'method' => 'POST']) !!}

                {!! Form::hidden('file', session('new_file')) !!}

                {!! Form::submit('Descargar archivo de errores', ['class' => 'btn btn-primary']) !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

