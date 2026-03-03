@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Agregar tipo de licencia
                </h3>
            </div>
            <div class="box-body">
                    <form action="{{ route('configuracion.licencia.store') }}" method="POST">@csrf

                    @include('Configuracion::tipo_presentismo.fields')

                    </form>
            </div>
        </div>
    </div>
@endsection
