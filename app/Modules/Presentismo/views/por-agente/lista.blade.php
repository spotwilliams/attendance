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
                    <div class="col-md-12">
                        @include('Presentismo::por-agente.form')

                    </div>
                </div>
            </div>
        </div>

        <div class="box box-warning">
            <div class="box-header with-border">
                <div class="col-md-12 col-xs-12 text-center">
                    {{ Form::open(['route' => 'presentismoPorAgenteRegistro', 'method' => 'POST', 'name' => 'presentismo-por-agente-param-form'])}}
                    <input type="hidden" name="desde" value="{{$desde->format('Y-m-d')}}" >
                    <input type="hidden" name="hasta" value="{{$hasta->format('Y-m-d')}}">
                    <input type="hidden" name="agente" value="{{$agentes->first()->id}}">
                    {{ Form::close() }}

                    <div class="fc-button-group">
                        <button type="button" class="btn btn-primary navegacion-btn retroceder-dias">
                            <span>
                                <i class="fa fa-backward"></i>&nbsp;
                                -{{config('cat.cant_dias_navegacion')}} d&iacute;as
                            </span>
                        </button>
                        <h4 class="box-title">
                            <span class="label label-default">{{$desde->format('d/m/Y')}}</span> hasta
                            <span class="label label-default">{{$hasta->format('d/m/Y')}}</span>
                        </h4>
                        <button type="button" class="btn btn-primary navegacion-btn avanzar-dias">
                            <span>
                                +{{config('cat.cant_dias_navegacion')}} d&iacute;as
                                &nbsp;<i class="fa fa-forward"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-flag-o"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-number">{{$baseActual->nombre}}</span>
                                {{--<span class="info-box-text">Base</span>--}}

                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <span class="progress-description">{{$agentes->total()}} agente encontrado</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        @include('Presentismo::registro.table')
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('parts.modal', ['idModal' => $idModal, 'titleModal' => 'Comentarios para la fecha'])
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.retroceder-dias').on('click', function (event) {
                var desde = moment($('[name="desde"]').val()).subtract({{config('cat.cant_dias_navegacion')}}, 'day');
                var hasta = moment($('[name="hasta"]').val()).subtract({{config('cat.cant_dias_navegacion')}}, 'day');

                $('[name="desde"]').val(desde.format('Y-MM-DD'));
                $('[name="hasta"]').val(hasta.format('Y-MM-DD'));

                $('[name="presentismo-por-agente-param-form"]').submit();
            });

            $('.avanzar-dias').on('click', function (event) {
                var desde = moment($('[name="desde"]').val()).add({{config('cat.cant_dias_navegacion')}}, 'day');
                var hasta = moment($('[name="hasta"]').val()).add({{config('cat.cant_dias_navegacion')}}, 'day');

                $('[name="desde"]').val(desde.format('Y-MM-DD'));
                $('[name="hasta"]').val(hasta.format('Y-MM-DD'));

                $('[name="presentismo-por-agente-param-form"]').submit();

            });
        })
    </script>
@append
