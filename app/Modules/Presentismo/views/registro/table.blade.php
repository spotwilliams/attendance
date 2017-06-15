<?php
use Cat\Helpers\HtmlCustoms;
/** @var \DateTime $fecha */
/** @var \DateTime $fechaJson */
/** @var \DateTime $fechaToday */
/** @var \Cat\Models\Periodo $periodo */
$fecha = new DateTime($periodo->fecha_comienzo);
$fecha->modify('-4day');
$fechaToday = (new DateTime('now'))->modify('+4day');

$fechasToShow = [];

while ($fecha < $fechaToday) {
    $fechasToShow[] = ['data' => $fecha->format('Y-m-d'), 'show' => $fecha->format('d/m')];
    $fecha->modify('+1day');
}


$selector = 'selectpicker';
$idModal = 'comentarios-modal'
?>
<div class="table-responsive">
    <table class="table hover" id="presentismos-table">
        <thead>
        <th>Id Agente</th>
        <th>Agente</th>
        <th>CUIT</th>
        @for($i = 0; $i < count($fechasToShow) ;$i++)
            <th data-cat="{{$fechasToShow[$i]['data']}}">{{$fechasToShow[$i]['show']}}</th>
        @endfor
        </thead>
        <tbody>
        @foreach($agentes as $age)
            <tr>
                <td>{{$age->id}}</td>
                <td>{{$age->apellido}}, {{$age->nombre}}</td>
                <td>{{$age->cuit}}</td>
                <?php $presentismos = $age->presentismos->keyBy('fecha'); ?>
                @for($i = 0; $i < count($fechasToShow) ;$i++)

                    <td><?php
                        $p = (isset($presentismos[$fechasToShow[$i]['data']]) ? $presentismos[$fechasToShow[$i]['data']] : null);
                        echo HtmlCustoms::getSelectForTipoPresentismo($p)
                        ?></td>
                @endfor

            </tr>
        @endforeach
        </tbody>
    </table>
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
                $('[data-toggle="popover"]').popover({
                    'html': true,
                });

                $('[data-toggle="popover"]')
                    .off('click')
                    .on('click', function () {
                        alert('holaaaa')
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
                    var agente = dataActual[0];
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
                    {{--var url = "{{route('presentismoTable', 'replace')}}";--}}
                //            var baseSelect = $('#base-select-with-button');

            var dataTable = $('#presentismos-table').DataTable({
                    searching: false,
                    ordering: false,
                    paging: false,
                    bInfo: false,
                });

            /**
             *
             * Accion para boton de modal
             *
             */
            $('.dialog-comentary')
                .on('click', function () {

                    var myParent = $(this).parent().parent();
                    console.log(myParent)
                    var fecha = datatableColumnHeaderValue(myParent, dataTable);
                    var agente = datatableCellValue(myParent, dataTable);
                    var presentismoParent = $(myParent).children('div');
                    var presentismoSelected = $(presentismoParent[0]).children('select');
                    var comentario = $(this).data('comentario');
                    // Parte visible
                    $('.modal-agente').html(agente[1]);
                    $('.modal-cuit').html(agente[2]);
                    $('.modal-fecha').html(fecha);
                    $('.modal-presentismo').html($(presentismoSelected).find(':selected').data('content'));
                    $('.modal-comentario').val(comentario);
                    // Hidden para ajax
                    $('.modal-id-agente').val(agente[0]);
                    $('.modal-id-tipo-presentismo').val($(presentismoSelected).val());

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