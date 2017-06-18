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
                <h4 class="box-title">
                    Agentes de la base <span class="label label-info">{{$baseActual->nombre}}</span>
{{--                    Periodo actual: <span class="label label-success">{{$desde->format('d/m/Y')}}</span> hasta <span--}}
                            {{--class="label label-success">{{$hasta->format('d/m/Y')}}</span>--}}
                    Turno <span class="label label-success">{{$turno->codigo}}</span>

                </h4>
            </div>

            <div class="box-body">
                @include('Presentismo::registro.table')
            </div>
            <div class="box-footer">
                <div class="col-md-6 col-md-offset-3">

                    {{$agentes->links()}}
                </div>

            </div>
        </div>
    </div>
    @include('parts.modal', ['idModal' => $idModal, 'titleModal' => 'Comentarios para la fecha'])
@endsection
