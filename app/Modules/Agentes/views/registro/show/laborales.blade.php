<?php
/** @var \Cat\Models\Contrato $contrato */

/** @var \Cat\Models\Agente $agente */
$contrato = $agente->contrato()->first();

/** @var \Cat\Models\TipoContrato $tipoContrato */
$tipoContrato = $contrato->tipoContrato()->first();

/** @var \Cat\Models\EstadoContrato $estadoContrato */
$estadoContrato = $contrato->estadoContrato()->first();

?>
<div class="table-responsive">
    <div class="col-md-6">
        <table class="table">
            <tbody>
            @if($tipoContrato->codigo === \Cat\Models\TipoContrato::TIPO_SITUACION_REVISTA)
                <tr>
                    <th>ID Sial:</th>
                    <td>{{$contrato->id_sial}}</td>
                </tr>
                <tr>
                    <th>Ficha:</th>
                    <td>{{$contrato->ficha}}</td>
                </tr>
            @endif
            <tr>
                <th>Fecha alta contrato:</th>
                @if($tipoContrato->isLocacion())
                    <td>{{(new DateTime($contrato->fecha_ingreso))->format('d/m/Y')}}</td>
                @else
                    <td>N/A</td>
                @endif
            </tr>
            <tr>
                <th>Fecha de ingreso al GCBA:</th>
                <td>{{(new DateTime($contrato->fecha_ingreso_gobierno))->format('d/m/Y')}}</td>
            </tr>
            <tr>
                <th>Tipo contrato:</th>
                <td>{{$tipoContrato->descripcion}}</td>
            </tr>
            <tr>
                <th>Tipo inscripci&oacute;n a IIBB:</th>
                @if($tipoContrato->isLocacion())
                    <td>{{$contrato->tipo_inscripcion}}</td>
                @else
                    <td>N/A</td>
                @endif
            </tr>
            <tr>
                <th>Estado:</th>
                <td>{{$estadoContrato->descripcion}}</td>
            </tr>
            @if(!$estadoContrato->esActivo())
                <tr>
                    <th>Fecha de baja:</th>
                    <td>{{(new DateTime($contrato->fecha_baja))->format('d/m/Y')}}</td>
                </tr>
                <tr>
                    <th>Comentarios de la baja:</th>
                    <td>{{$contrato->comentario_baja}}</td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>
</div>
