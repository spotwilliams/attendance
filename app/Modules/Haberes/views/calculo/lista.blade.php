<?php

/** @var \DateTime $fecha */
/** @var \Cat\Models\Periodo $periodo */
$fecha      = new DateTime($periodo->fecha_comienzo);
$fechaToday = (new DateTime($periodo->fecha_fin));

$fechasToShow = [];

while ($fecha < $fechaToday) {
    $fechasToShow[] = ['data' => $fecha->format('Y-m-d'), 'show' => $fecha->format('d/m')];
    $fecha->modify('+1day');
}

?>

@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">C&aacute;lculo de haberes</h3>
                <div class="box-tools pull-right">
                    @if($estadoPeriodo->estaAbierto())
                        {!! Form::open(['route' => 'haberesConfirmarDisclaimer']) !!}
                        {!! Form::hidden('periodo', $periodo->id) !!}
                        {!! Form::hidden('base', $base->id) !!}
                        {!! Form::hidden('turno', $turno->id) !!}
                        <input type="submit"
                               class="btn btn-primary"
                               value='Confimar presentismos'/>
                        {!! Form::close() !!}
                    @endif
                </div>

            </div>

            <div class="box-body">
                <div class="form-group col-sm-10 col-sm-offset-1">
                    <div class="progress-group ">
                        <span class="progress-text">Paso 3</span>
                        <span class="progress-number"><b>3</b>/4</span>

                        <div class="progress">
                            <div class="progress-bar progress-bar-yellow" style="width: 75%"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h4 class="box-title">Base <span class="label label-info">{{$base->nombre}}</span></h4>
                    </div>
                    <div class="col-md-2">
                        <h4 class="box-title">Turno <span class="label label-info">{{$turno->codigo}}</span></h4>
                    </div>
                    <div class="col-md-4">
                        <h4 class="box-title">
                            Periodo <span
                                    class="label label-info">{{(new DateTime($periodo->fecha_comienzo))->format('d/m/Y')}}</span>
                            hasta <span
                                    class="label label-info">{{(new DateTime($periodo->fecha_fin))->format('d/m/Y')}}</span>
                        </h4>
                    </div>
                </div>

                <table class="table table-hover" id="haberes-table">
                    <thead>
                    <th>Detalles</th>
                    <th>Agente</th>
                    <th>DNI</th>
                    <th>CUIT</th>
                    {{--<th>Confirmar</th>--}}
                    </thead>
                    <tbody>
                    @if(!$estadoPeriodo->estaAbierto())
                        <tr>
                            <td colspan="10">
                                <div class="col-md-offset-2 col-md-6">

                                    <div class="alert alert-info alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                        </button>
                                        <h4><i class="icon fa fa-info"></i> Aviso</h4>
                                        Los presentismos para esta base y turno ya han sido cerrados.
                                    </div>
                                    {!! Form::open(['route' => 'haberesReporte', 'method' => 'POST']) !!}
                                    {!! Form::hidden('periodo', $periodo->id) !!}
                                    {!! Form::hidden('turno', $turno->id) !!}
                                    {!! Form::hidden('base', $base->id) !!}
                                    <button type="submit" class="btn btn-success pull-right">
                                        <i class="fa fa-download"></i> Obtener reporte
                                    </button>
                                    {!! Form::close() !!}
                                    <a class="btn btn-primary" href="{{route('haberesSelectBase')}}">Volver</a>
                                </div>
                            </td>
                        </tr>
                    @elseif($agentes->isEmpty())
                        <tr>
                            <td colspan="10">
                                <div class="col-md-offset-2 col-md-6">

                                    <div class="alert alert-info alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                        </button>
                                        <h4><i class="icon fa fa-info"></i> Aviso</h4>
                                        No existen agentes con contrato de locaci&oacute;n para la base y turno.
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @if($turno->esFinDeSemana())
                        @include('Haberes::calculo.weekend')
                    @else
                        @include('Haberes::calculo.all-days')
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <div class="col-md-6 col-md-offset-3">

                    {{$agentes->links()}}
                </div>

            </div>
        </div>
    </div>
    @include('parts.modal', ['idModal' => 'comentarios-modal', 'titleModal' => 'Comentarios para la fecha'])

@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $('table tbody').on('click', 'tr > td > a.details-control', function () {
                var tr = $(this).closest('tr');
                var nextTr = $(tr).next('tr');
                var button = $(this);//.children('a');
                var icon = $(this).children('i');
                // Si es visible lo tengo que esconder
                if ($(nextTr).is(':visible')) {

                    $(nextTr).addClass('hidden');

                    if (!$(button).hasClass('btn-default')) {
                        $(button).addClass('btn-success');
                        $(button).removeClass('btn-danger');

                    }
                    $(icon).addClass('fa-plus-circle');
                    $(icon).removeClass('fa-minus-circle');


                } else {
                    var cell = $(nextTr).children('td');
                    var data = $(nextTr).children('input').data('presentismos');
                    $(nextTr).removeClass('hidden');
                    if (!$(button).hasClass('btn-default')) {

                        $(button).addClass('btn-danger');
                        $(button).removeClass('btn-success');

                    }
                    $(icon).addClass('fa-minus-circle');
                    $(icon).removeClass('fa-plus-circle');

                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            function activarPopOver() {
                $('[data-toggle="popover"]')
                    .popover({
                        'html': true,

                    })
                    .off('click')
                    .on('click', function () {
                        $('[data-toggle="popover"]').popover('hide');
                        var myParent = $(this).parent().parent();
                        var data = $(this).data('presentismo');
                        var url = null;

                        if (data.injustificado === 1) {
                            url = '{{route('presentismoJustificar')}}';
                        } else {
                            url = '{{route('presentismoInjustificar')}}';

                        }
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: data,
                            success: function (xhr, other) {

                                var messageTxt = xhr.message;
                                var presentismo = xhr.presentismo;
                                var button = xhr.button;
                                var level = 'success';
                                renderAgainButtonsAndSelect(myParent, messageTxt, presentismo, button, level)

                            },
                            error: function (xhr, other) {
                                var messageTxt = xhr.responseJSON.message;
                                var presentismo = xhr.responseJSON.presentismo;
                                var button = xhr.responseJSON.button;
                                var level = 'error';
                                renderAgainButtonsAndSelect(myParent, messageTxt, presentismo, button, level)

                            }

                        });
                    });
            }

            function message(obj, message, presentismo, type) {

                var ref = $(obj).children('.selectpicker').context;
                var wait = 2000;

                $(ref)
                    .prop('value', presentismo)
                    .prop('disabled', false)
                    .selectpicker('refresh');
                $(obj).children('.overlay').remove();

//                $(ref).hide();
                var messenger = $(ref).parents('.input-group.margin')[0];
                $(obj).notify(message,
                    {
                        autoHide: true,
                        // if autoHide, hide after milliseconds
                        autoHideDelay: wait,
                        position: 'top',
                        showAnimation: 'slideDown',
                        className: type,
                    });
            }

            function renderAgainButtonsAndSelect(myParent, messageTxt, presentismo, button, level) {
                var contailerToolButtons = myParent.children('.tools-presentismo');

                $(contailerToolButtons).children('[data-toggle="popover"]').remove();
                $(contailerToolButtons).append(button);

                var btnComment = $(contailerToolButtons).children('.dialog-comentary');
                $(btnComment).removeAttr('disabled');

                activarPopOver();
                message(myParent, messageTxt, presentismo.id_tipo_presentismo, level);
            }

            activarPopOver();
            /**
             *
             * Select picker
             *
             */
            $('.selectpicker')
                .selectpicker({})
                .on('change', function (event) {
                    var mySelf = $(this);
                    /**
                     *
                     *
                     * Efecto after select
                     *
                     *
                     *
                     */
                    var overlay = '<div class=\'overlay\'><i class=\'fa fa-refresh fa-spin\'></i></div>';
                    var myParent = $(this).parent().parent();
                    $(this).prop('disabled', true).selectpicker('refresh');
                    $(myParent[0]).append(overlay);
                    /**
                     *
                     *
                     * Ajax Reaction
                     *
                     *
                     *
                     */
                    var agenteData = $(this).parents().closest('.col-xs-2').children('input');
                    var agente = $(agenteData).data('agente');
                    var presentismoData = $(this).parents().closest('.form-group').children('.tools-presentismo').children('[data-toggle="popover"]');
                    var presentismo = $(presentismoData).data('presentismo');

                    $.ajax({
                        url: '{{route('presentismoStore')}}',
                        type: 'POST',
                        data: {
                            'agente': agente.id,
                            'presentismo': $(this).val(),
                            'fecha': presentismo.fecha,
                        },
                        success: function (xhr, other) {

                            var messageTxt = xhr.message;
                            var presentismo = xhr.presentismo;
                            var button = xhr.button;
                            var level = 'success';
                            renderAgainButtonsAndSelect(myParent, messageTxt, presentismo, button, level)

                        },
                        error: function (xhr, other) {
                            var messageTxt = xhr.responseJSON.message;
                            var presentismo = xhr.responseJSON.presentismo;
                            var button = xhr.responseJSON.button;
                            var level = 'error';
                            renderAgainButtonsAndSelect(myParent, messageTxt, presentismo, button, level)

                        }

                    });
                });

            /**
             *
             * Creacion Datatables
             *
             */

            /**
             *
             * Accion para boton de modal
             *
             */
            $('.dialog-comentary')
                .on('click', function () {

                    var bro = $(this)
                        .parent()
                        .children('[data-toggle="popover"]');

                    var presentismo = $(bro)
                        .data('presentismo');

                    var agenteData = $(this).parents().closest('.col-xs-2').children('input');
                    var agente = $(agenteData).data('agente');

                    var presentismoSelect = $(this).parents().closest('.form-group').children('.bootstrap-select').children('select');
                    var tipoPresentismo = $(presentismoSelect).find(':selected').data('content');
                    // Parte visible
                    $('.modal-agente').html(agente.apellido + ',' + agente.nombre);
                    $('.modal-cuit').html(agente.cuit);
                    $('.modal-fecha').html(presentismo.fecha);
                    $('.modal-presentismo').html(tipoPresentismo);
                    $('.modal-comentario').val($(this).data('comentario'));
                    // Hidden para ajax
                    $('.modal-id-agente').val(presentismo.id_agente);
                    $('.modal-id-tipo-presentismo').val(presentismo.id_tipo_presentismo);

                    $('#comentarios-modal').data('dialog-comentary', $(this));

                    $('#comentarios-modal').modal();


                });

            $('.modal-save')
                .off('click')
                .on('click', function () {
                    var fecha = $('.modal-fecha').html();
                    var idTipoPresentismo = $('.modal-id-tipo-presentismo').val();
                    var idAgente = $('.modal-id-agente').val();

                    var data = {
                        'id_tipo_presentismo': idTipoPresentismo,
                        'id_agente': idAgente,
                        'fecha': fecha,
                        'comentario': $('.modal-comentario').val(),
                    };
                    $.ajax({
                        url: '{{route('presentismoComment')}}',
                        type: 'POST',
                        data: data,
                        success: function (xhr, other) {
                            var button = $('#comentarios-modal').data('dialog-comentary');
                            button.addClass('bg-gray-active')
                                .removeClass('btn-default')
                                .data('comentario', $('.modal-comentario').val());

                            $('#comentarios-modal').modal('toggle');
                            message(button, xhr.message, idTipoPresentismo, 'success');

                        },
                        error: function (xhr, other) {
                            var message = (xhr.responseJSON.message === undefined) ? xhr.responseJSON.comentario[0] : xhr.responseJSON.message;
                            $('.modal-save').notify(message,
                                {
                                    autoHide: true,
                                    // if autoHide, hide after milliseconds
                                    autoHideDelay: 2000,
                                    position: 'top',
                                    showAnimation: 'slideDown',
                                    className: 'error'
                                });
                        }
                    });

                });

        });

    </script>
@append