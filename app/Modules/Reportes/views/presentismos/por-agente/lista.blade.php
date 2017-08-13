<?php

$idModal = 'comentarios-modal'
?>


@extends('layouts.app')

@section('content')

    <div class="content">

        <div class="clearfix"></div>
        @include('flash::message')


        <div class="clearfix"></div>

        <div class="box box-warning collapsed-box">
            <div class="box-header with-border">
                <h4 class="box-title">Buscar nuevamente</h4>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa  fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-10">
                        @include('Reportes::presentismos.por-agente.form')

                    </div>
                </div>
            </div>
        </div>

        <div class="box box-warning">
            <div class="box-header with-border">
                <div class="col-md-4 col-xs-4">
                    <h4 class="box-title"><span class="hidden-xs">Base</span> <span
                                class="label label-info">{{$baseActual->nombre}}</span></h4>
                </div>
                <div class="col-md-4 col-xs-6">
                    <h4 class="box-title"><span class="hidden-xs">Periodo actual:</span>
                        <span class="label label-info">{{$desde->format('d/m/Y')}}</span> hasta
                        <span class="label label-info">{{$hasta->format('d/m/Y')}}</span>

                    </h4>
                </div>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        @include('Presentismo::registro.table')
                    </div>
                </div>
            </div>
            <div class="box-footer">
            </div>
        </div>
    </div>
@endsection
