@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <?php

        $mesFacturacion = \Illuminate\Support\Facades\Date::createFromFormat('Y-m-d', $periodo->fecha_fin);
        $mesFacturacion->addMonth(1);

        $start = \Illuminate\Support\Facades\Date::createFromFormat('Y-m-d', $periodo->fecha_comienzo);
        $end = \Illuminate\Support\Facades\Date::createFromFormat('Y-m-d', $periodo->fecha_fin);
        ?>
        <div class="box box-warning">

            <div class="box-header text-center">
                <h4 class="box-title"><span class="label label-success">Notificaci&oacute;n de facturas</span> para
                    <span class="label label-info">{{trans('month.'.$mesFacturacion->format('m'))}}
                        '{{$mesFacturacion->format('y')}}</span> <span
                            class="label label-default">({{$start->format('d/m/Y')}} - {{$end->format('d/m/Y')}})</span>
                </h4>

            </div>
            <div class="box-body text-center">
                <div class="col-md-12">
                    @include('Haberes::notificacion.parts.disclaimer-regular')
                </div>
            </div>

        </div>

        <div class="box">

            <form action="" method="POST" class="form-horizontal">@csrf
            <div class="box-header with-border">
                <h3 class="box-title">
                    Se enviar&aacute; mail notificando a <span
                            class="label label-info">@if(isset($agentes)){{$agentes->count()}}@else{{0}}@endif</span>
                    agentes</h3>
                <div class="box-tools pull-right">
                    <input type="hidden" name="periodo" value="{{$periodo->id}}">

                    <div class="btn-group">
                        <button type="submit" class="btn btn-default atras">
                            <i class="fa fa-refresh"></i>&nbsp;<span class="hidden-xs">Volver a buscar</span>
                        </button>
                        <button type="submit" class="btn btn-primary enviar">
                            <i class="fa fa-send"></i>&nbsp;<span class="hidden-xs">Enviar notificaci&oacute;n</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="box-body">
                <div class="row">

                    @include('Haberes::notificacion.mails.fields-common')
                    <div class="col-md-12">
                        @include('Haberes::notificacion.parts.table-resumen')
                    </div>
                </div>

            </div>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.fecha').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2018,
                maxYear: parseInt(moment().format('YYYY'), 10),
                startDate: moment()
            });
            $('button.atras, button.enviar').on('click', function (event) {
                event.preventDefault();
                var $form = $('form');
                if ($(this).hasClass('atras')) {
                    $form.prop('action', '{{route('notificacionSearch')}}')
                }
                if ($(this).hasClass('enviar')) {
                    $form.prop('action', '{{route('enviarNotificacionRegular')}}')
                }
                $form.submit();
            });
        })
    </script>
@append


