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
                    <th>Nivel:</th>
                    <td>{{$e->nivel}}</td>
                </tr>
                </tbody>
            </table>
        @endforeach
    </div>
</div>

