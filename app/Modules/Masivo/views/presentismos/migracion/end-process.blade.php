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

                        <div class="col-md-4 col-sm-offset-2">
                            {!! Form::open(['route' => 'presentismosMasivoMigracionDownload', 'method' => 'POST']) !!}

                            {!! Form::hidden('file', session('presentismos_new_file')) !!}

                            {!! Form::submit('Descargar archivo de errores', ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

