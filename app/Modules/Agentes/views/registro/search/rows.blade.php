<?php
$desdePre = (new DateTime('now'))->modify('-5day')->format('Y-m-d');
$hastaPre =(new DateTime('now'))->modify('+5day')->format('Y-m-d');
?>
@forelse ($agentes as $agente)
    <tr>
        <td>{{$agente->apellido}}, {{$agente->nombre}}</td>
        <td>{{$agente->cuit}}</td>
        <td>@if(isset($agente->operativo))
                {{$agente->operativo->base->nombre}}
            @endif
        </td>
        @include('Agentes::registro.commons.operaciones-celda')
    </tr>
    @endforeach
