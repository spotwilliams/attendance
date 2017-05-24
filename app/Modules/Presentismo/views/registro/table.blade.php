<?php
/** @var \DateTime $fecha */
/** @var \DateTime $fechaJson */
/** @var \DateTime $fechaToday */
/** @var \Cat\Models\Periodo $periodo */
$fecha = new DateTime($periodo->fecha_comienzo);
$fechaJson = new DateTime($periodo->fecha_comienzo);
$fechaToday = (new DateTime('now'))->modify('+1day');
$selector = 'selectpicker';
?>
<table class="table table-responsive" id="presentismos-table">
    <thead>
    <th>Id Agente</th>
    <th>Agente</th>
    <th>CUIT</th>
    @while( $fecha < $fechaToday)
        <th data-cat="{{$fecha->format('Y-m-d')}}">{{$fecha->format('m/d')}}</th>
        <?php $fecha->modify('+1day'); ?>
    @endwhile
    </thead>
</table>

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
                            var trActual = myParent.parents('tr')[0];
                            var dataRow = dataTable.row(trActual);
                            var dataActual = dataRow.data();
                            var agente = dataActual.id;

                            var tdActual = myParent[0];
                            var idx = dataTable.cell(tdActual).index().column;
                            var header = dataTable.column(idx).header();
                            var fecha = $(header).data('cat');


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
                                },
                                error: function (xhr, other) {
                                    message(myParent, xhr.message, xhr.presentismo, 'error');
                                }

                            });
                        });
            }


            function message(obj, message, presentismo, type) {

                var ref = $(obj).children('.{{$selector}}').context;
                $(ref)
                        .prop('value', presentismo)
                        .prop('disabled', false)
                        .selectpicker('refresh');
                $(obj).children('.overlay').remove();

                $(ref).notify(message,
                        {
                            autoHide: true,
                            // if autoHide, hide after milliseconds
                            autoHideDelay: 2000,
                            position: 'top',
                            showAnimation: 'slideDown',
                            className: type,
                        });
            }

            function createSelect(seleccionado) {
                var tipoPresentismos = {!!  \Cat\Models\TipoPresentismo::all()->toJson()!!};
                var container = $('<div class="form-group">');
                container.append($('<div class="input-group margin">'));

                var select = $('<select class="{{$selector}} form-control" data-width="80px">')
                select.append('<option value="-1">...</option>');
                for (var i = 0; i < tipoPresentismos.length; i++) {
                    select.append(
                            '<option value="' + tipoPresentismos[i].id + '"'
                            + ((tipoPresentismos[i].id === seleccionado) ? ' selected ' : '')
                            + 'data-content="'
                            + '<span class=\'label\' style=\'background-color: ' + tipoPresentismos[i].color + ';\'>' + tipoPresentismos[i].descripcion + '</span>">'
                            + tipoPresentismos[i].descripcion + '</option>');
                }
                return container.children('div').append(select);

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
                            for (var i = 0; i < agente.presentismos.length; i++) {
                                if (agente.presentismos[i].fecha === '{{$fechaJson->format('Y-m-d')}}') {
                                    presentismo = agente.presentismos[i].presentismo;
                                }
                            }
                            var element = createSelect(presentismo);
                            return element.html();
                        },
                        name: '{{$fechaJson->format('Y-m-d')}}',
                        <?php $fechaJson->modify('+1day'); ?>

                    },
                    @endwhile

                ],
                initComplete: function () {
                    configurarSelect();
                    this.api().columns().every(function () {
                        var column = this;
                        var input = document.createElement("input");
                        $(input).appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    column.search($(this).val()).draw();
                                });
                    });
                }
            });

        });

    </script>
@append