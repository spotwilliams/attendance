<?php

$mesFacturacion = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_fin);
$mesFacturacion->addMonth(1);

$start = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_comienzo);
$end = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_fin);
?>

<div class="col-md-offset-3 col-md-6">
    <div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-warning"></i> Aviso: Est&aacute; a punto de enviar un mail de notificaci&oacute;n.</h4>
        Los agentes listados recibir&aacute;n un mail a la casilla especificada, con el mensaje descrito en el campo "Mensaje" del formulario siguiente.

    </div>
</div>