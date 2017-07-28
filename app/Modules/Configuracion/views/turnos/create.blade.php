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
                    {!! Form::open(['route' => 'configuracion.turno.store']) !!}

                    @include('Configuracion::turnos.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
