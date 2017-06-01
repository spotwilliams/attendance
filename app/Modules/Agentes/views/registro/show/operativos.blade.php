<?php
/** @var \Cat\Models\Operativo $operativo */

/** @var \Cat\Models\Agente $agente */
$operativo = $agente->operativo()->first();

/** @var \Cat\Models\Gerencia $gerencia */
$gerencia      = $operativo->gerencia()->first();
$gerenciaPadre = $gerencia->padre()->first();

$nombreGerencia    = $NombreSubgerencia = 'No posee';

if ($gerenciaPadre !== null) {

    $nombreGerencia    = $gerenciaPadre->nombre;
    $NombreSubgerencia = $gerencia->nombre;
} else {

    if (str_contains(strtolower($gerencia->nombre), 'subgerencia')) {
        $NombreSubgerencia = $gerencia->nombre;
    } else {
        $nombreGerencia    = $gerencia->nombre;
    }
}

/** @var \Cat\Models\Area $area */
$area = $operativo->area()->first();

/** @var \Cat\Models\Cargo $cargo */
$cargo = $operativo->cargo()->first();

/** @var \Cat\Models\Funcion $funcion */
$funcion = $operativo->funcion()->first();

$funcionPadre = $funcion->padre()->first();

/** @var \Cat\Models\Horario $horario */
$horario = $operativo->horario()->first();

/** @var \Cat\Models\Base $base */
$base = $operativo->base()->first();

/** @var \Cat\Models\Turno $turno */
$turno = $operativo->turno()->first();


?>
<div class="table-responsive">
    <table class="table">
        <tbody>
        <tr>
            <th>Gerencia:</th>
            <td>{{$nombreGerencia}}</td>
        </tr>
        <tr>
            <th>Subgerencia:</th>
            <td>{{$NombreSubgerencia}}</td>
        </tr>
        <tr>
            <th>Area:</th>
            <td>{{$area->nombre}}</td>
        </tr>
        <tr>
            <th>Cargo:</th>
            <td>{{$cargo->nombre}}</td>
        </tr>
        <tr>
            <th>Funci&oacute;n:</th>
            <td>{{$funcionPadre->nombre}}</td>
        </tr>
        <tr>
            <th>Funci&oacute;n espec&iacute;fica:</th>
            <td>{{$funcion->nombre}}</td>
        </tr>

        <tr>
            <th>Base:</th>
            <td>{{$base->nombre}}</td>
        </tr>
        <tr>
            <th>Turno:</th>
            <td>{{$turno->codigo}}</td>
        </tr>
        <tr>
            <th>Horario:</th>
            <td>{{$horario->hora_entrada}} a {{$horario->hora_salida}}</td>
        </tr>


        </tbody>
    </table>
</div>

