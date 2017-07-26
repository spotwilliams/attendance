<?php

/** @var array $fechasToShow */
if (isset($desde) and isset($hasta)) {
    $fechasToShow = \Cat\Helpers\Calculation::getAllDaysBetween($desde, $hasta);
} else {
    $fechasToShow = [];
}

/** @var \Illuminate\Pagination\LengthAwarePaginator $presentismos */

?>

@foreach($agentes as $agente)
    <tr>
        <td>{{$agente->nombre}}, {{$agente->apellido}}</td>
        <td>{{$agente->cuit}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','base', 'nombre'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','turno', 'codigo'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['operativo','area', 'nombre'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($agente,['contrato','tipoContrato', 'descripcion'])}}</td>
        <?php
        $pByFecha = $agente->presentismos->keyBy('fecha');
        ?>
        @foreach($fechasToShow as $fecha)
            @if($pByFecha->get($fecha)!==null)
                <td>{!! $pByFecha->get($fecha)->tipoPresentismo->getMyLabel() !!}</td>
            @else
                <td>N/A</td>
            @endif
        @endforeach
    </tr>
@endforeach