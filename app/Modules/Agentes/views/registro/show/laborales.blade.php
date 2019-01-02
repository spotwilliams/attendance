<?php

/** @var \Cat\Models\Agente $agente */
try {
    /** @var \Cat\Models\Contrato $contrato */
    $contrato = $agente->contratoActual()->firstOrFail();
    /** @var \Cat\Models\TipoContrato $tipoContrato */
    $tipoContrato   = $contrato->tipoContrato()->firstOrFail();
    $estadoContrato = $contrato->estadoContrato()->firstOrFail();
} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
}


?>
<div class="table-responsive">
    <div class="col-md-6">
        @if($agente->contrato()->first())
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
                    <th>Fecha ingreso modalidad actual:</th>
                    @if($contrato->fecha_ingreso === '1900-01-01')
                        <td>No definido</td>
                    @else
                        <td>{{(new DateTime($contrato->fecha_ingreso))->format('d/m/Y')}}</td>
                    @endif
                </tr>
                @if($tipoContrato->codigo === \Cat\Models\TipoContrato::TIPO_LOCACION)
                    <tr>
                        <th>Fecha fin modalidad actual:</th>
                        <td>{{(new DateTime($contrato->fecha_fin))->format('d/m/Y')}}</td>
                    </tr>

                @endif
                <tr>
                    <th>Fecha de ingreso al GCBA:</th>
                    @if($contrato->fecha_ingreso_gobierno === '1900-01-01')
                        <td>No definido</td>
                    @else
                        <td>{{(new DateTime($contrato->fecha_ingreso_gobierno))->format('d/m/Y')}}</td>
                    @endif
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
                        <td>{{(new DateTime($contrato->fecha_estado_desde))->format('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <th>Comentarios de la baja:</th>
                        <td>{{$contrato->comentario}}</td>
                    </tr>
                @endif
                @if($estadoContrato->id === \Cat\Models\EstadoContrato::comision()->id)
                    <tr>
                        <th>Desde:</th>
                        <td>{{(new DateTime($contrato->fecha_estado_desde))->format('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <th>Hasta:</th>
                        <td>{{(new DateTime($contrato->fecha_estado_hasta))->format('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <th>Comentarios de comisi&oacute;n:</th>
                        <td>{{$contrato->comentario}}</td>
                    </tr>
                @endif

                </tbody>
            </table>
        @else
            <p>No hay datos laborales para mostrar</p>
        @endif
    </div>
</div>
