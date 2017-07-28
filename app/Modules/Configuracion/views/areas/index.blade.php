@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Listado de &aacute;reas</h3>
                <div class="pull-right">
                    <a class="btn btn-success pull-right" href="{!! route('configuracion.area.create') !!}">Agregar nueva</a>
                </div>
            </div>
            <div class="box-body">
                    @include('Configuracion::areas.table')
            </div>
        </div>
    </div>
@endsection

