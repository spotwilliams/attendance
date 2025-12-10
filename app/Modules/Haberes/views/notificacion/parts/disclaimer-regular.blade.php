<?php

$mesFacturacion = \Illuminate\Support\Facades\Date::createFromFormat('Y-m-d', $periodo->fecha_fin);
$mesFacturacion->addMonth(1);

$start = \Illuminate\Support\Facades\Date::createFromFormat('Y-m-d', $periodo->fecha_comienzo);
$end = \Illuminate\Support\Facades\Date::createFromFormat('Y-m-d', $periodo->fecha_fin);
?>

<div class="col-md-offset-3 col-md-6">
    <div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-warning"></i> Aviso: Est&aacute; a punto de enviar un mail de notificaci&oacute;n.</h4>
        Los agentes listados recibir&aacute;n un mail a la casilla especificada, notificando que debe presentar la factura correspondiente al periodo {{trans('month.'.$mesFacturacion->format('m'))}} ({{$start->format('d/m/Y')}} - {{$end->format('d/m/Y')}}), con los valores indicados en la lista.

    </div>
</div>