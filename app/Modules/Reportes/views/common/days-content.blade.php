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
        <td>{{$agente->apellido}}, {{$agente->nombre}}</td>
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
                <td>{!! $pByFecha->get($fecha)->tipoPresentismo->getMyLabel() !!}
                    @if(($incluir_comentarios == true)and ($pByFecha->get($fecha)->comentario!==null))
                        @include('Reportes::common.comentarios', ['comentarios' => $pByFecha->get($fecha)->comentarios])
                    @endif
                </td>
            @else
                <td>S/D</td>
            @endif
        @endforeach
    </tr>
@endforeach

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover({
                trigger: 'hover'
            });
        })
    </script>
    @append