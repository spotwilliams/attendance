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
                <form action="{{ route('agentesMasivoDownload') }}" method="POST">@csrf

                <input type="hidden" name="file" value="{{ session('agentes_new_file') }}">

                <a class="btn btn-default pull-left" href="{{URL::previous()}}"><i class="fa fa-arrow-left"></i>Volver</a>
                <button type="submit" class="btn btn-primary pull-right">Descargar archivo de errores</button>

                </form>
            </div>
        </div>
    </div>
@endsection


