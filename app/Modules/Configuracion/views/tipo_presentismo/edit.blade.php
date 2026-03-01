@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Tipo de licencia
                </h3>
            </div>
            <div class="box-body">
                    <form action="{{ route('configuracion.licencia.update', $tipo->id) }}" method="POST">@csrf @method('PATCH')

                    @include('Configuracion::tipo_presentismo.fields', ['aplicaDisabled' => true])

                    </form>
            </div>
        </div>
    </div>
@endsection