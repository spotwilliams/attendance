@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Editar nombre de base
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    {!! Form::model($baseModel, ['route' => ['configuracion.base.update', $baseModel->id], 'method' => 'patch']) !!}

                    @include('Configuracion::bases.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection