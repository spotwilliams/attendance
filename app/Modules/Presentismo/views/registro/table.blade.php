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
        'day'  => $fecha->format('D')
    ];
    $fecha->modify('+1day');
}


$selector = 'selectpicker';
$idModal = 'comentarios-modal'
?>
<div class="row">

    <div class="col-md-12">
        <div class="">
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
        </div>
    </div>
</div>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
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

                var ref = $(obj).children('.{{$selector}}').context;
                var wait = 2000;

                $(ref)
                    .prop('value', presentismo)
                    .prop('disabled', false)
                    .selectpicker('refresh');
                $(obj).children('.overlay-td').remove();

//                $(ref).hide();
//                var messenger = $(ref).parents('.input-group.margin')[0];
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

            var dataTable = $('#presentismos-table').DataTable({
                searching: false,
                ordering: false,
                paging: false,
                bInfo: false,
                fixedHeader: true,
            });

            /**
             *
             * Accion para boton de modal
             *
             */
            $('.dialog-comentary')
                .on('click', function () {
                    $('.no-comment').addClass('hidden');

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
                    if ($(this).data('comentario') !== '') {
                        $('.no-comment').removeClass('hidden');
                    }
                    // Hidden para ajax
                    $('.modal-id-agente').val(idAgente);
                    $('.modal-id-tipo-presentismo').val($(presentismoSelected).val());

                    $('#{{$idModal}}').data('dialog-comentary', $(this));
                    $('#{{$idModal}}').modal();


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

                            var button = $('#{{$idModal}}').data('dialog-comentary');
                            button.addClass('bg-gray-active')
                                .removeClass('btn-default')
                                .data('comentario', xhr.presentismo.comentario)
                                .data('usuario-comentario', xhr.usuario.name)
                                .data('usuario-fecha', xhr.fecha_comentario)
                            $('.no-comment').removeClass('hidden');
                            ;

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