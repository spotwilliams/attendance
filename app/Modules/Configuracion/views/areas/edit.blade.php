@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Area
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    {!! Form::model($area, ['route' => ['configuracion.area.update', $area->id], 'method' => 'patch']) !!}

                    @include('Configuracion::areas.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection