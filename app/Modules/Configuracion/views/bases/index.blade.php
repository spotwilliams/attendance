@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Listado de bases</h3>
                <div class="box-tools pull-right">
                    <a class="btn btn-success pull-right"
                       href="{!! route('configuracion.base.create') !!}">Agregar nueva</a>
                </div>
            </div>
            <div class="box-body">
                    @include('Configuracion::bases.table')
            </div>
        </div>
    </div>
@endsection

