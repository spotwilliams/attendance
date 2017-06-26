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
            <tr>
                <th>ID Sial:</th>
                <td>{{$contrato->id_sial}}</td>
            </tr>
            <tr>
                <th>Ficha:</th>
                <td>{{$contrato->ficha}}</td>
            </tr>
            <tr>
                <th>Fecha comienzo:</th>
                <td>{{(new DateTime($contrato->fecha_ingreso))->format('d/m/Y')}}</td>
            </tr>
            <tr>
                <th>Tipo contrato:</th>
                <td>{{$tipoContrato->descripcion}}</td>
            </tr>
            <tr>
                <th>Estado contrato:</th>
                <td>{{$estadoContrato->descripcion}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
