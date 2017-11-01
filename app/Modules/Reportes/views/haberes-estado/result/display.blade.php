<?php
/** @var \Illuminate\Support\Collection $periodos */
if (!isset($data)) {
    $periodos = new \Illuminate\Support\Collection();
} else {
    $periodos = $data;
}
?>

<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Resultados obtenidos</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12 col-xs-12">

            <table class="table table-responsive">
                <thead>
                <tr>
                    <th>Periodo</th>
                    <th>Base</th>
                    <th>Turno</th>
                    <th>Estado</th>
                    <th>Monto total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($periodos->groupBy('periodo.id') as $periodo)
                    @foreach($periodo as $estado)
                        <tr>
                            <td> Periodo comprendido desde
                                <span class="label label-success">{{(new DateTime($periodo->first()->periodo->fecha_comienzo))->format('d/m/Y')}}</span>
                                al
                                <span class="label label-success">{{(new DateTime($periodo->first()->periodo->fecha_fin))->format('d/m/Y')}}</span>
                            </td>
                            <td>{{$estado->base->nombre}}</td>
                            <td>{{$estado->turno->codigo}}</td>
                            <td>
                                <span class="label @if($estado->abierto) label-warning @else label-success @endif">
                                @if($estado->abierto) Abierto @else Cerrado @endif
                                </span>
                            </td>
                            <td><?php

                                $monto = \Cat\Helpers\Calculation::getMontoAcumulado($estado->periodo, $estado->base,
                                    $estado->turno);
                                if ($estado->abierto) {

                                    echo 'Periodo no cerrado';
                                } else {
                                    if (!$monto->total) {
                                        echo '$ 0';
                                    } else {
                                        echo '$' . $monto->total;
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('css')
    <style media="screen">
        tr.group,
        tr.group:hover {
            background-color: #ddd !important;
        }
    </style>
@append

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            var tableMain = $('.table.table-responsive').DataTable({
                columnDefs: [
                    {visible: false, targets: 0}
                ],
                paging: false,
                pageLength: 60,
                searching: false,
                ordering: false,
                scrollY: 500,
                scrollCollapse: false,
                "order": [[2, 'asc']],
                "displayLength": 25,
                "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({page: 'current'}).nodes();
                    var last = null;

                    api.column(0, {page: 'current'}).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td colspan="6">' + group + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
            });
            tableMain.columns.adjust();
        })
    </script>
@append