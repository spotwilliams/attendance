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
        <div class="col-md-12 col-xs-12 table-responsive">
            <table>
                @foreach($periodos->groupBy('periodo.id') as $periodo)
                    <tr>
                        <td colspan="4" style="background-color: darkgrey"> Periodo comprendido desde
                            <span class="label label-success">{{(new DateTime($periodo->first()->periodo->fecha_comienzo))->format('d/m/Y')}}</span>
                            al
                            <span class="label label-success">{{(new DateTime($periodo->first()->periodo->fecha_fin))->format('d/m/Y')}}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Base</th>
                        <th>Turno</th>
                        <th>Estado</th>
                        <th>Monto facturado</th>
                    </tr>
                    @foreach($periodo as $estado)
                        <tr>
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
                                if (!$monto->total) {
                                    echo 'Periodo no cerrado';
                                } else {
                                    echo '$' . $monto->total;
                                }
                                ?></td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
        </div>
    </div>
</div>
