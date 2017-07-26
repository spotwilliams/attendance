@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Nueva base
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'configuracion.base.store']) !!}
                    @include('Configuracion::bases.fields')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
