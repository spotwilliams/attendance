<?php

$mesFacturacion = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_fin);
$mesFacturacion->addMonth(1);

$start = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_comienzo);
$end   = \Carbon\Carbon::createFromFormat('Y-m-d', $periodo->fecha_fin);

?>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td bgcolor="#41f49b" nowrap>
            <img border="0"
                 src="{{ Request::getSchemeAndHttpHost() }}/vendor/beautymail/assets/images/widgets/spacer.gif"
                 width="5" height="1">
        </td>
        <td width="100%" bgcolor="#ffffff">

            <table width="100%" cellpadding="20" cellspacing="0" border="0">
                <tr>
                    <td bgcolor="#ffffff" class="contentblock">
                        Estimado/a <b>{{$agente->apellido}}, {{$agente->nombre}}</b>, se le comunica que tiene tiempo
                        hasta el <b>XXX</b> para presentar la factura correspondiente a
                        <b> {{trans('month.'.$mesFacturacion->format('m'))}} ({{$start->format('d/m/Y')}}
                            - {{$end->format('d/m/Y')}})</b>,
                        por un valor de <b>$ {{$detalle['monto']}}</b>.
                        <br/>
                        <br/>
                        Durante las fechas mencionadas se han registrado que usted tiene <b>{{$detalle['diasADescontar']}}</b> falta/s
                        injustificada/s.
                        <br/>
                        <br/>
                        Ante cualquier duda o consulta, no dude en comunicarse con nosotros.
                        <br/>
                        <br/>
                        Muchas gracias.
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
<img border="0" src="{{ Request::getSchemeAndHttpHost() }}/vendor/beautymail/assets/images/widgets/spacer.gif" width="1"
     height="15" class="divider">
<br>
