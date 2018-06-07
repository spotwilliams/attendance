@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <?php

        $mesFacturacion = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_fin);
        $mesFacturacion->addMonth(1);

        $start = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_comienzo);
        $end = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_fin);
        ?>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Notificar facturas de <span class="label label-info">{{trans('month.'.$mesFacturacion->format('m'))}}
                        '{{$mesFacturacion->format('y')}}</span> <span
                            class="label label-default">({{$start->format('d/m/Y')}} - {{$end->format('d/m/Y')}})</span>
                </h3>
            </div>

            <div class="box-body">

                <div class="col-md-10 col-md-offset-1">

                    <div class="form-group">
                        <div class="progress-group">
                            <span class="progress-text">Paso 2 - Seleccionar agentes</span>
                            <span class="progress-number"><b>2</b>/4</span>

                            <div class="progress">
                                <div class="progress-bar progress-bar-yellow" style="width: 50%"></div>
                            </div>
                        </div>
                    </div>


                    @include('Haberes::notificacion.parts.form-filtros')
                </div>

            </div>
            <div class="box-footer">
            </div>
        </div>

        <div class="box">
            {!! Form::open(['method' => 'POST', 'route' => 'notificacionCalcular']) !!}
            <input type="hidden" name="periodo" value="{{$periodo->id}}">

            <div class="box-header with-border">
                <h3 class="box-title"><span
                            class="label label-info">@if(isset($agentes)){{$agentes->count()}}@else{{0}}@endif</span>
                    agentes encontrados</h3>
                <div class="box-tools pull-right">
                    <div class="btn-group">
                        <a class="btn btn-default ninguno" href="{{route('notificacionIndex')}}"><i class="fa fa-backward"></i>&nbsp;Atr&aacute;s</a>
                        <a class="btn btn-default ninguno">Ninguno</a>
                        <a class="btn btn-default todos">Todos</a>
                        <input type="submit" value="Siguiente" class="btn btn-primary">
                    </div>
                </div>
            </div>

            <div class="box-body">

                <div class="col-md-12">

                    @include('Haberes::notificacion.parts.table-agentes')
                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $('a.todos, a.ninguno').on('click', function () {
                if ($(this).hasClass('ninguno')) {
                    $('input[type="checkbox"].agente-option').prop('checked', false);
                } else {
                    $('input[type="checkbox"].agente-option').prop('checked', true);
                }
            });

        })
    </script>
@append

