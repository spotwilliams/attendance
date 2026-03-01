@extends('layouts.app')

@section('content')
    <section class="content-header">
    </section>
    <div class="content">

        <div class="box box-warning">
            <div class="box-header">

                <h3 class="box-title">
                    Agregar nuevo turno
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <form action="{{ route('configuracion.turno.store') }}" method="POST">@csrf

                    @include('Configuracion::turnos.fields')

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
