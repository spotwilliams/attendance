<?php
$idModal = 'modal-agentes';
?>
<table class="display" cellspacing="0" width="100%" id="presentismos-table">
    <thead>
    <th>Id Agente</th>
    <th>Agente</th>
    <th>CUIT</th>
    <th>Operaciones</th>
    </thead>
</table>
@include('parts.modal', ['idModal' => $idModal, 'titleModal' => 'Datos del agente'])
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

            function message(obj, message, presentismo, type) {

                var wait = 2000;
                $(obj).children('.overlay').remove();

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


            /**
             *
             * Creacion Datatables
             *
             */
            var url = "{{route('agentesTable', 'replace')}}";
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
                    {
                        data: 'action',
                        searchable:false,
                        orderable: false,
                    }

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