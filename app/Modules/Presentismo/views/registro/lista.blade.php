<?php

$idModal = 'comentarios-modal'
?>


@extends('layouts.app')

@section('content')

    <div class="content">

        <div class="clearfix"></div>
        @include('flash::message')

        @include('Presentismo::registro.form-box', ['collapsed' => true, 'title' => 'Seleccionar otra base y/o periodo'])

        <div class="clearfix"></div>

        <div class="box box-warning">
            <div class="box-header with-border">
                <div class="col-md-4">
                    <h4 class="box-title">Base <span class="label label-info">{{$baseActual->nombre}}</span></h4>
                </div>
                <div class="col-md-4">
                    {{--<h4 class="box-title">Turno <span class="label label-info">{{$turno->codigo}}</span></h4>--}}
                </div>
                <div class="col-md-4">
                    <h4 class="box-title">Periodo actual: <span
                                class="label label-info">{{$desde->format('d/m/Y')}}</span> hasta <span
                                class="label label-info">{{$hasta->format('d/m/Y')}}</span>

                    </h4>
                </div>
            </div>

            <div class="box-body">
                @include('Presentismo::registro.table')
            </div>
            <div class="box-footer">
                <div class="text-center">
                    {!! $links !!}
                </div>

            </div>
        </div>
    </div>
    @include('parts.modal', ['idModal' => $idModal, 'titleModal' => 'Comentarios para la fecha'])
@endsection
