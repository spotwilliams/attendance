<?php
/** @var \Cat\Models\Contrato $contrato */

/** @var \Cat\Models\Agente $agente */
$domicilios = $agente->domicilios()->get();

/** @var \Cat\Models\TipoContrato $tipoContrato */
$estudios = $agente->estudio()->get();

?>
<div class="table-responsive">
    <div class="col-md-12">
        <label>Domicilios</label>
        @foreach($domicilios as $d)
            <table class="table">
                <tbody>
                <tr>
                    <th>Calle:</th>
                    <td>{{$d->calle}}</td>
                </tr>
                <tr>
                    <th>N&uacute;mero:</th>
                    <td>{{$d->numero}}</td>
                </tr>
                <tr>
                    <th>Departamento:</th>
                    <td>{{$d->departamento}}</td>
                </tr>
                <tr>
                    <th>Piso:</th>
                    <td>{{$d->piso}}</td>
                </tr>
                <tr>
                    <th>Barrio:</th>
                    <td>{{$d->barrio}}</td>
                </tr>
                <tr>
                    <th>Provincia:</th>
                    <td>{{$d->provincia}}</td>
                </tr>
                <tr>
                    <th>Es constituido:</th>
                    <td>@if($d->constituido === 0) NO @else SI @endif</td>
                </tr>
                <tr>
                    <th>Otro dato:</th>
                    <td>{{$d->libre}}</td>
                </tr>
                </tbody>
            </table>
        @endforeach
    </div>
    <div class="col-md-12">
        <label>Estudios</label>
        @foreach($estudios as $e)
            <table class="table">
                <tbody>
                <tr>
                    <th>T&iacute;tulo:</th>
                    <td>{{$d->carrera}}</td>
                </tr>
                <tr>
                    <th>Institucu&oacute;n:</th>
                    <td>{{$e->institucion}}</td>
                </tr>
                <tr>
                    <th>Nivel:</th>
                    <td>{{$e->nivel}}</td>
                </tr>
                <tr>
                    <th>Estado:</th>
                    <td>{{$e->estado}}</td>
                </tr>
                </tbody>
            </table>
        @endforeach
    </div>
</div>

