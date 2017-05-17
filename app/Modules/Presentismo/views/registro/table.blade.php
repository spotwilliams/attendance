<?php
$today = new DateTime();
$diasMesActual = cal_days_in_month(CAL_GREGORIAN, $today->format('m'), $today->format('Y'));
$diasMesActual = 5;
?>
<table class="table table-responsive" id="presentismos-table">
    <thead>
    <th>Id Agente</th>
    <th>Agente</th>
    <th>CUIT</th>
    @for($day = 1; $day <= $diasMesActual;$day++)
        <th data-cat="{{$today->format('Y-m')}}-{{$day}}">{{$day}}/{{$today->format('m')}}</th>
    @endfor
    </thead>
    <tbody>
    @foreach($agentes as $agente)
        <?php
        // Para cada agente, en una fecha particular,
        // tengo que ver si tiene cargado un presentismo o no
        ?>
        <tr>
            <td>{{$agente->id}}</td>
            <td>{{ $agente->nombre . ' ' . $agente->apellido}}</td>
            <td>{{ $agente->cuit }}</td>
            @for($day = 1; $day <= $diasMesActual;$day++)
                <td>@include('presentismos.select', ['classSelector' => $selector ='selectpicker'])</td>
            @endfor
        </tr>
    @endforeach
    </tbody>
</table>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            /**
             *
             * Creacion Datatables
             *
             */
            var dataTable = $('#presentismos-table').DataTable({
                "scrollX": true,
                "columnDefs": [
                    {
                        "targets": [0],
                        "visible": false,
                    },
                ]
            });

            /**
             *
             * Select picker
             *
             */
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
                        var overlay = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
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
                        var agente = dataActual[0];

                        var tdActual = myParent.parents('td')[0];
                        var idx = dataTable.cell(tdActual).index().column;
                        var header = dataTable.column(idx).header();
                        var fecha = $(header).data('cat');


                        $.ajax({
                            url: '{{route('presentismoStore')}}',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: 'POST',
                            data: {
                                'agente': agente,
                                'presentismo': $(this).val(),
                                'fecha': fecha,
                            },
                            onSuccess: function () {

                            },
                            onError: function () {

                            }
                        });
                    });
        });
    </script>
@append