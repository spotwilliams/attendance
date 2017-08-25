@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Agregar tipo de presentismo
                </h3>
            </div>
            <div class="box-body">
                    {!! Form::open(['route' => 'configuracion.licencia.store']) !!}

                    @include('Configuracion::tipo_presentismo.fields')

                    {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
