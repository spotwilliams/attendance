@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Lista de turnos</h3>
                <div class="box-tools">
                    <a class="btn btn-success pull-right" href="{!! route('configuracion.turno.create') !!}">Agregar
                        nuevo</a>
                </div>
            </div>
            <div class="box-body">
                @include('Configuracion::turnos.table')
            </div>
        </div>
    </div>
@endsection

