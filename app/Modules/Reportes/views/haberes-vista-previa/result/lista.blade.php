<?php
/*
 * La primera vez que se carga la seccion no se ha seleccionado un periodo.
 *
 */

$fechasToShow = [];

if (isset($periodo)) {

    /** @var \DateTime $fecha */
    /** @var \Cat\Models\Periodo $periodo */
    $fecha      = new DateTime($periodo->fecha_comienzo);
    $fechaToday = (new DateTime($periodo->fecha_fin));

    while ($fecha < $fechaToday) {
        $fechasToShow[] = ['data' => $fecha->format('Y-m-d'), 'show' => $fecha->format('d/m')];
        $fecha->modify('+1day');
    }
}

?>


<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Resultados</h3>
    </div>

    <div class="box-body">
        @if(isset($agentes))
            <table class="table table-hover" id="haberes-table">
                <thead>
                <th>Detalles</th>
                <th>Personal</th>
                <th>CUIT</th>
                <th></th>
                </thead>
                <tbody>
                @if($estadoPeriodo->estaAbierto())
                    @include('Reportes::haberes-vista-previa.result.all-days')
                @else
                    <tr>
                        <th align="center" colspan="3"><span class="label label-info">El peri&oacute;do se encuentra cerrado para la base y turno seleccionado</span>
                        </th>
                    </tr>
                @endif
                </tbody>
            </table>
        @endif
    </div>
    <div class="box-footer">
        <div class="col-md-6 col-md-offset-3">
            @if(isset($agentes))
                {{$agentes->links()}}
            @endif
        </div>

    </div>
</div>

@include('parts.modal', ['idModal' => 'comentarios-modal', 'titleModal' => 'Comentarios para la fecha'])

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var tablaComentario = null;

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

                        if (data.injustificado == true) {
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
                myParent.children('.tools-presentismo').remove();

                $(myParent).append(button);

                activarPopOver();
                activarButtonComentario();
                message(myParent, messageTxt, presentismo.id_tipo_presentismo, level);
            }

            /**
             *
             * Accion para boton de modal
             *
             */
            function activarButtonComentario() {

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
                        $('.modal-comentario-usuario').html($(this).data('usuario-comentario'));
                        $('.modal-comentario-fecha').html($(this).data('fecha-comentario'));
                        $('.modal-cuit').html(agente.cuit);
                        $('.modal-fecha').html(presentismo.fecha);
                        $('.modal-presentismo').html(tipoPresentismo);
                        $('.modal-comentario').val($(this).data('comentario'));
                        // Hidden para ajax
                        $('.modal-id-agente').val(presentismo.id_agente);
                        $('.modal-id-presentismo').val($(this).data('id-presentismo'));

                        $('#comentarios-modal').data('dialog-comentary', $(this));

                        $('#comentarios-modal').modal();

                        var tableUrl = '{{route('presentismoCommentLista', ['id' => 'id'])}}';
                        var url = tableUrl.replace('id', $(this).data('id-presentismo'));
                        if (tablaComentario == null) {
                            tablaComentario = $('.table-comentario').DataTable({
                                ajax: url,
                                type: 'GET',
                                columns: [
                                    {
                                        data: function (comentario) {
                                            return comentario.comentario;
                                        },

                                    },
                                    {
                                        data: function (comentario) {
                                            return moment(comentario.created_at).format('DD/MM/YYYY, h:mm a');
                                        },
                                    },
                                    {
                                        data: function (comentario) {
                                            return comentario.user.email;
                                        },
                                    },
                                ],
                                paging: true,
                                ordering: false,
                                searching: false,
                                pageLength: 4,
                            });
                        } else {
                            tablaComentario.ajax.url(url).load();
                        }


                    });
            }

            activarPopOver();
            activarButtonComentario();
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



            $('.modal-save')
                .off('click')
                .on('click', function () {
                    var idTipoPresentismo = $('.modal-id-presentismo').val();

                    var data = {
                        'id_presentismo': idTipoPresentismo,
                        'comentario': $('.modal-comentario').val(),
                    };
                    $.ajax({
                        url: '{{route('presentismoComment')}}',
                        type: 'POST',
                        data: data,
                        success: function (xhr, other) {
                            var button = $('#comentarios-modal').data('dialog-comentary');
                            button.children('i')
                                .removeClass('fa-comment-o')
                                .addClass('fa-comment text-yellow text-warning');

                            $('.no-comment').removeClass('hidden');


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