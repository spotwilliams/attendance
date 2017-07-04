<?php
/** @var \Cat\Models\Contrato $contrato */

/** @var \Cat\Models\Agente $agente */
$domicilios = $agente->domicilios()->get();

/** @var \Cat\Models\TipoContrato $tipoContrato */
$estudios = $agente->estudio()->get();

?>
<div class="table-responsive">
    <div class="col-md-12">
        <h4>Domicilios</h4>
        @if($domicilios->isEmpty())
            <p class="help-block">No se registraron domicilios</p>
        @else
            @foreach($domicilios as $d)
                <table class="table">
                    <tbody>
                    <tr>
                        <th>Calle:</th>
                        <td>{{$d->calle}}</td>
                        <th>N&uacute;mero:</th>
                        <td>{{$d->numero}}</td>
                        <th>Departamento:</th>
                        <td>{{$d->departamento}}</td>
                        <th>Piso:</th>
                        <td>{{$d->piso}}</td>
                    </tr>
                    <tr>
                        <th>Barrio:</th>
                        <td>{{$d->barrio}}</td>
                        <th>Provincia:</th>
                        <td colspan="2">{{$d->provincia}}</td>
                        <th>Es constituido:</th>
                        <td>@if($d->constituido === false) NO @else SI @endif</td>
                    </tr>
                    <tr>
                        <th>Otro dato:</th>
                        <td colspan="6">{{$d->libre}}</td>
                    </tr>
                    </tbody>
                </table>
                <hr>
            @endforeach
        @endif
    </div>
    <div class="col-md-12">
        <h4>Estudios</h4>
        @if($estudios->isEmpty())
            <p class="help-block">No se registraron domicilios</p>
        @else
            @foreach($estudios as $e)
                <table class="table">
                    <tbody>
                    <tr>
                        <th>T&iacute;tulo:</th>
                        <td>{{$e->carrera}}</td>

                        <th>Institucu&oacute;n:</th>
                        <td>{{$e->institucion}}</td>
                    </tr>
                    <tr>
                        <th>Nivel:</th>
                        <td>{{$e->nivel}}</td>

                        <th>Estado:</th>
                        <td>{{$e->estado}}</td>
                    </tr>
                    </tbody>
                </table>
                <hr>

            @endforeach
        @endif

    </div>
</div>

