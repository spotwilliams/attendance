<?php
/** @var \DateTime $fecha */
/** @var \DateTime $fechaJson */
/** @var \DateTime $fechaToday */
/** @var \Cat\Models\Periodo $periodo */
$fecha      = new DateTime($desde->format('Y-m-d'));
$fechaToday = new DateTime($hasta->format('Y-m-d'));

$fechasToShow = [];

while ($fecha <= $fechaToday) {
    $fechasToShow[] = [
        'data' => $fecha->format('Y-m-d'),
        'show' => $fecha->format('d/m'),
        'day'  => $fecha->format('D'),
        'obj'  => new DateTime($fecha->format('Y-m-d'))
    ];
    $fecha->modify('+1day');
}


$selector = 'selectpicker';
$idModal  = 'comentarios-modal'
?>

<table class="table hover" id="presentismos-table">
    <thead>
    <th>Personal</th>
    <th>CUIT</th>
    <th>Mod. Contratacion</th>
    @for($i = 0; $i < count($fechasToShow) ;$i++)
        <th data-cat="{{$fechasToShow[$i]['data']}}">{{$fechasToShow[$i]['show']}}</th>
    @endfor
    </thead>

    @include('Presentismo::registro.footer')

    @include('Presentismo::registro.all-day')
    <tbody>
    </tbody>
</table>
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var tablaComentario = null;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            function activarPopOver() {
                $('[data-toggle="popover"]')
                    .popover({
                        'html': true,
                        'placement': 'bottom'

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

                var ref = $(obj).children('.{{$selector}}').context;
                var wait = 2000;

                $(ref)
                    .prop('value', presentismo)
                    .prop('disabled', false)
                    .selectpicker('refresh');
                $(obj).children('.overlay-td').remove();

                $(obj).notify(message,
                    {
                        autoHide: true,
                        // if autoHide, hide after milliseconds
                        autoHideDelay: wait,
                        position: 'left',
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

            function activarButtonComentario() {
                $('.dialog-comentary')
                    .on('click', function () {
                        var myParent = $(this).parent().parent();
                        var idAgente = $(this).parents().closest('td').data('agente');
                        var fecha = datatableColumnHeaderValue(myParent, dataTable);
                        var agente = datatableCellValue(myParent, dataTable);
                        var presentismoParent = $(myParent).children('div');
                        var presentismoSelected = $(presentismoParent[0]).children('select');
                        var comentario = $(this).data('comentario');
                        // Parte visible

                        $('.modal-agente').html(agente[0]);
                        $('.modal-cuit').html(agente[1]);
                        $('.modal-fecha').html(fecha);
                        $('.modal-presentismo').html($(presentismoSelected).find(':selected').data('content'));
                        $('.modal-comentario').val(comentario);
                        $('.modal-comentario-usuario').html($(this).data('usuario-comentario'));
                        $('.modal-comentario-fecha').html($(this).data('fecha-comentario'));

                        // Hidden para ajax
                        $('.modal-id-agente').val(idAgente);
                        $('.modal-id-presentismo').val($(this).data('id-presentismo'));

                        $('#{{$idModal}}').data('dialog-comentary', $(this));
                        $('#{{$idModal}}').modal();


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
            $('.{{$selector}}')
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
                    var overlay = '<div class=\'overlay-td\'><i class=\'fa fa-refresh fa-spin\'></i></div>';
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
                    var dataActual = datatableCellValue(myParent, dataTable);
                    var agente = $(myParent).parent('td').data('agente');
                    var fecha = datatableColumnHeaderValue(myParent, dataTable);//$(header).data('cat');


                    $.ajax({
                        url: '{{route('presentismoStore')}}',
                        headers: {},
                        type: 'POST',
                        data: {
                            'agente': agente,
                            'presentismo': $(this).val(),
                            'fecha': fecha,
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

            var dataTable = $('#presentismos-table').DataTable({
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function (row) {
                                var data = row.data();
                                return '<span class="label label-warning">Aviso<span>';
                            },
                        }),
                        renderer: function (api, rowIdx, columns) {

                            var mssg = '<p class="help-block">No hay suficiente espacio en la pantalla para mostrar todas las fechas.<br>' +
                                'Por favor aumente la resoluci&oacute;n de su navegador o seleccione un menor rango de fechas.</p>';

                            return $('<table/>').append(mssg);
                        },
                    }
                },
                searching: false,
                ordering: false,
                paging: false,
                bInfo: false,
            });
            new $.fn.dataTable.FixedHeader(dataTable);

            /**
             *
             * Accion para boton de modal
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

                            var button = $('#{{$idModal}}').data('dialog-comentary');
                            button.children('i')
                                .removeClass('fa-comment-o')
                                .addClass('fa-comment text-yellow text-warning');

                            $('#{{$idModal}}').modal('toggle');
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