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
                    {!! Form::model($turnoModel, ['route' => ['configuracion.turno.update', $turnoModel->id], 'method' => 'patch']) !!}

                    @include('Configuracion::turnos.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection