<?php
use Cat\Models\TipoPresentismo;
use Cat\Helpers\HtmlCustoms;
use Cat\Repositories\TipoPresentismosRepository;

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
                    @if(!$agentes->isEmpty())
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
                <div class="form-group">
                    <h4 class="col-sm-8 col-sm-offset-2">
                        Base <span class="label label-info">{{$base->nombre}}</span>
                        Periodo <span
                                class="label label-success">{{(new DateTime($periodo->fecha_comienzo))->format('d/m/Y')}}</span>
                        hasta <span
                                class="label label-success">{{(new DateTime($periodo->fecha_fin))->format('d/m/Y')}}</span>
                        Turno <span class="label label-info">{{$turno->codigo}}</span>
                    </h4>
                    <div class="progress-group col-sm-8 col-sm-offset-2">
                        <span class="progress-text">Paso 3</span>
                        <span class="progress-number"><b>3</b>/4</span>

                        <div class="progress">
                            <div class="progress-bar progress-bar-yellow" style="width: 75%"></div>
                        </div>
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
                    @if($agentes->isEmpty())
                        <tr>
                            <td colspan="10">
                                <p class="help-block">Los presentismos para esta base y turno ya han sido cerrados.</p>
                                <a class="btn btn-primary" href="{{route('haberesSelectBase')}}">Volver</a>
                            </td>
                        </tr>
                    @endif
                    @foreach($agentes as $a)
                        <tr>
                            <td class="details-control">
                                @if($a->presentismos->isEmpty())
                                    <a class="btn btn-default details-control"><i class="fa fa-plus-circle"></i></a>
                                @else
                                    <a class="btn btn-success details-control"><i class="fa fa-plus-circle"></i></a>
                                @endif
                            </td>

                            <td>{{$a->apellido}}, {{$a->nombre}}</td>
                            <td>{{$a->dni}}</td>
                            <td>{{$a->cuit}}</td>
                        </tr>
                        <tr class="hidden">
                            <input type="hidden" data-presentismos="{{$a->presentismos}}">
                            <td colspan="10">
                                @if($a->presentismos->isEmpty())
                                    <p class="help-block">No se registraron faltas injustificadas en el periodo.</p>
                                @else
                                    <div class="row">
                                        @foreach($a->presentismos as $p)
                                            <div class="col-xs-2">
                                                <label>{{(new DateTime($p->fecha))->format('d/m')}}</label>
                                                <input type="hidden" data-agente="{{json_encode($a->getAttributes())}}">
                                                {!! HtmlCustoms::getSelectForTipoPresentismo($p, $a->contrato->tipoContrato) !!}

                                            </div>
                                        @endforeach
                                    </div>

                                @endif


                            </td>
                        </tr>

                    @endforeach
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
                                renderAgaingButtonsAndSelect(myParent, messageTxt, presentismo, button, level)

                            },
                            error: function (xhr, other) {
                                var messageTxt = xhr.responseJSON.message;
                                var presentismo = xhr.responseJSON.presentismo;
                                var button = xhr.responseJSON.button;
                                var level = 'error';
                                renderAgaingButtonsAndSelect(myParent, messageTxt, presentismo, button, level)

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

                $(ref).hide();
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

            function renderAgaingButtonsAndSelect(myParent, messageTxt, presentismo, button, level) {
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
                            renderAgaingButtonsAndSelect(myParent, messageTxt, presentismo, button, level)

                        },
                        error: function (xhr, other) {
                            var messageTxt = xhr.responseJSON.message;
                            var presentismo = xhr.responseJSON.presentismo;
                            var button = xhr.responseJSON.button;
                            var level = 'error';
                            renderAgaingButtonsAndSelect(myParent, messageTxt, presentismo, button, level)

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
                            $('.modal-save').notify(xhr.message,
                                {
                                    autoHide: true,
                                    // if autoHide, hide after milliseconds
                                    autoHideDelay: 2000,
                                    position: 'top',
                                    showAnimation: 'slideDown',
                                    className: 'success'
                                });
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