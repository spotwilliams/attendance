@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Turno Model
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <form action="{{ route('configuracion.turno.update', $turnoModel->id) }}" method="POST">@csrf @method('PATCH')

                    @include('Configuracion::turnos.fields')

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection