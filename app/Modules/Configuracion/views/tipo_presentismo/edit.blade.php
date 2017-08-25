@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Tipo de presentismo
                </h3>
            </div>
            <div class="box-body">
                    {!! Form::model($tipo, ['route' => ['configuracion.licencia.update', $tipo->id], 'method' => 'patch']) !!}

                    @include('Configuracion::tipo_presentismo.fields')

                    {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection