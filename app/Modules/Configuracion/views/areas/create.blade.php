@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Agregar &aacute;rea
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <form action="{{ route('configuracion.area.store') }}" method="POST">@csrf

                    @include('Configuracion::areas.fields')

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
