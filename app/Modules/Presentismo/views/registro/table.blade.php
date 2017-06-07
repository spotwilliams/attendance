<?php
/** @var \DateTime $fecha */
/** @var \DateTime $fechaJson */
/** @var \DateTime $fechaToday */
/** @var \Cat\Models\Periodo $periodo */
$fecha = new DateTime($periodo->fecha_comienzo);
$fechaJson = new DateTime($periodo->fecha_comienzo);
$fechaToday = (new DateTime('now'))->modify('+1day');
$selector = 'selectpicker';
$idModal = 'comentarios-modal'
?>
<table class="display" cellspacing="0" width="100%" id="presentismos-table">
    <thead>
    <th>Id Agente</th>
    <th>Agente</th>
    <th>CUIT</th>
    @while( $fecha < $fechaToday)
        <th data-cat="{{$fecha->format('Y-m-d')}}">{{$fecha->format('d/m')}}</th>
        <?php $fecha->modify('+1day'); ?>
    @endwhile
    </thead>
</table>
@include('parts.modal', ['idModal' => $idModal, 'titleModal' => 'Comentarios para la fecha'])
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });


            /**
             *
             * Select picker
             *
             */
            function configurarSelect() {
                $('.{{$selector}}')
                        .selectpicker({})
                        .off('change')
                        .on('change', function (event) {
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
                            myParent.append(overlay);
                            /**
                             *
                             *
                             * Ajax Reaction
                             *
                             *
                             *
                             */
                            var dataActual = datatableCellValue(myParent, dataTable);
                            var agente = dataActual.id;
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
                                    message(myParent, xhr.message, xhr.presentismo, 'success');
                                    var btnComment = $(myParent).children()[1];
                                    $(btnComment).removeAttr('disabled');

                                },
                                error: function (xhr, other) {
                                    message(myParent, xhr.responseJSON.message, xhr.presentismo, 'error');
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
                $(obj).children('.overlay').remove();

                $(ref).hide();
                var messenger = $(ref).parents('.input-group.margin')[0];
                $(messenger).notify(message,
                        {
                            autoHide: true,
                            // if autoHide, hide after milliseconds
                            autoHideDelay: wait,
                            position: 'top',
                            showAnimation: 'slideDown',
                            className: type,
                        });
            }

            function createSelect(seleccionado, comentario) {

                var tipoPresentismos = {!!  \Cat\Models\TipoPresentismo::all()->toJson()!!};
                var container = $('<div class="form-group">');
                container.append($('<div class="input-group margin">'));

                var select = $('<select class="{{$selector}} form-control" data-live-search="true" data-width="80px">')
                select.append('<option value="-1">...</option>');
                for (var i = 0; i < tipoPresentismos.length; i++) {
                    select.append(
                            '<option value="' + tipoPresentismos[i].id + '"'
                            + ((tipoPresentismos[i].id === seleccionado) ? ' selected ' : '')
                            + 'data-content="'
                            + '<span class=\'label\' style=\'background-color: ' + tipoPresentismos[i].color + ';\'>' + tipoPresentismos[i].descripcion + '</span>">'
                            + tipoPresentismos[i].descripcion + '</option>');
                }
                container.children('div').append(select);
                var buttonClass = ((comentario !== undefined) && (comentario !== null) ) ? 'btn-success' : 'btn-default';
                var buttonDisabled = (seleccionado === -1) ? ' disabled ' : '';
                container.children('div').append('<button type=\'button\' class=\' btn ' + buttonClass + ' dialog-comentary\' ' + buttonDisabled + '><i class=\'fa fa-comment-o\'/> </button>');
                return container;

            }

            /**
             *
             * Creacion Datatables
             *
             */
            var url = "{{route('presentismoTable', 'replace')}}";
            var baseSelect = $('#base-select-with-button');

            var dataTable = $('#presentismos-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: true,
//                scrollY: 500,
//                scrollCollapse: true,
                columnDefs: [
                    {
                        targets: [0],
                        visible: false,
                        searchable: false
                    },
                ],
                ajax: {
                    url: url.replace('replace', baseSelect.val()),
                    method: 'POST'
                },
                columns: [
                    {
                        name: 'id',
                        data: 'id',
                    },
                    {
                        name: 'nombre',
                        data: function (agente) {
                            return agente.apellido + ', ' + agente.nombre;
                        },
                    },
                    {
                        data: 'cuit',
                        name: 'cuit'
                    },
                        @while( $fechaJson < $fechaToday)
                    {
                        data: function (agente) {

                            var presentismo = -1;
                            var comentario = undefined;
                            for (var i = 0; i < agente.presentismos.length; i++) {
                                if (agente.presentismos[i].fecha === '{{$fechaJson->format('Y-m-d')}}') {
                                    presentismo = agente.presentismos[i].presentismo;
                                    comentario = agente.presentismos[i].comentario;
                                }
                            }
                            var element = createSelect(presentismo, comentario);
                            return element.html();
                        },
                        name: '{{$fechaJson->format('Y-m-d')}}',
                        <?php $fechaJson->modify('+1day'); ?>

                    },
                    @endwhile

                ],
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var input = document.createElement("input");
                        $(input).appendTo($(column.footer()).empty())
                        //                                .off('change')
                                .on('change', function () {
                                    column.search($(this).val()).draw();
                                });
                    });
                },
                drawCallback: function (settings) {
                    configurarSelect();
                    configurarButtons();
                }
            });

            /**
             *
             * Accion para boton de modal
             *
             */
            function configurarButtons() {
                $('.dialog-comentary')
                        .off('click')
                        .on('click', function () {

                            var myParent = $(this).parent().parent();
                            var fecha = datatableColumnHeaderValue(myParent, dataTable);
                            var agente = datatableCellValue(myParent, dataTable);
                            var presentismoParent = $(myParent).children().children();
                            var presentismoSelected = $(presentismoParent[2]).children('select');
                            var comentario = undefined;

                            // Para buscar los posibles comentarios anteriores
                            for (var i = 0; i < agente.presentismos.length; i++) {
                                if (agente.presentismos[i].fecha === fecha) {
                                    comentario = agente.presentismos[i].comentario;
                                    break;
                                }
                            }

                            // Parte visible
                            $('.modal-agente').html(agente.apellido + ', ' + agente.nombre);
                            $('.modal-cuit').html(agente.cuit);
                            $('.modal-fecha').html(fecha);
                            $('.modal-presentismo').html($(presentismoSelected).find(':selected').data('content'));
                            $('.modal-comentario').val(comentario);
                            // Hidden para ajax
                            $('.modal-id-agente').val(agente.id);
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
//                                console.log(xhr)
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
            }
        });

    </script>
@append