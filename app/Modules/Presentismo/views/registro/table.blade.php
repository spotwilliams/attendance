<?php
$today         = new DateTime();
$diasMesActual = cal_days_in_month(CAL_GREGORIAN, $today->format('m'), $today->format('Y'));
$diasMesActual = 5;
?>
<table class="table table-responsive" id="presentismos-table">
    <thead>
        <th>Nombre y Apellido</th>
        <th>CUIT</th>
        @for($day = 1; $day <= $diasMesActual;$day++)
            <th>{{$day}}/{{$today->format('m')}}</th>
        @endfor
    </thead>
    <tbody>
    @foreach($agentes as $agente)
        <?php
            // Para cada agente, en una fecha particular,
            // tengo que ver si tiene cargado un presentismo o no
        ?>
        <tr>
            <td>{!! $agente->nombre . ' ' . $agente->apellido  !!}</td>
            <td>{!! $agente->cuit !!}</td>
            @for($day = 1; $day <= $diasMesActual;$day++)
                <td>@include('presentismos.select')</td>
            @endfor
        </tr>
    @endforeach
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {
//        $('#presentismos-table').DataTable({
//            "scrollX": true
//        });
    });
</script>