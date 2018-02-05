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
                <div class="col-md-12 col-xs-12 d-flex align-items-center">
                    <h4 class="box-title">
                        <span class="label label-info">{{$desde->format('d/m/Y')}}</span> hasta
                        <span class="label label-info">{{$hasta->format('d/m/Y')}}</span>
                    </h4>
                </div>
            </div>
            <div class="box-body">
                <div class="col-md-4 col-xs-4">
                    <h4 class="box-title"><span class="hidden-xs">Base</span> <span class="label label-info">{{$baseActual->nombre}}</span></h4>
                </div>
                <div class="col-md-4 col-xs-4">
                    <h4 class="box-title">Agentes: <span class="label label-info">{{$agentes->total()}}</span></h4>
                </div>

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
