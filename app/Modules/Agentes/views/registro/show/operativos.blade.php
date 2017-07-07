<?php
/** @var \Cat\Models\Operativo $operativo */

/** @var \Cat\Models\Agente $agente */
$operativo = $agente->operativo()->first();


/** @var \Cat\Models\Gerencia $gerencia */
$gerencia       = $operativo->gerencia()->first();
$nombreGerencia = $NombreSubgerencia = 'No posee';
if ($gerencia !== null) {
    $gerenciaPadre = $gerencia->padre()->first();


    if ($gerenciaPadre !== null) {

        $nombreGerencia    = $gerenciaPadre->nombre;
        $NombreSubgerencia = $gerencia->nombre;
    } else {

        if (str_contains(strtolower($gerencia->nombre), 'subgerencia')) {
            $NombreSubgerencia = $gerencia->nombre;
        } else {
            $nombreGerencia = $gerencia->nombre;
        }
    }
}

/** @var \Cat\Models\Area $area */
$area = $operativo->area()->first();

/** @var \Cat\Models\Cargo $cargo */
$cargo = $operativo->cargo()->first();

/** @var \Cat\Models\Funcion $funcion */
$funcion = $operativo->funcion()->first();

/** @var \Cat\Models\Horario $horario */
$horario = $operativo->horario()->first();

/** @var \Cat\Models\Base $base */
$base = $operativo->base()->first();

/** @var \Cat\Models\Turno $turno */
$turno = $operativo->turno()->first();


?>
<div class="table-responsive">
    <div class="col-md-6">

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
                <td>{{isset($area->nombre)?$area->nombre:'No posee'}}</td>
            </tr>
            <tr>
                <th>Cargo:</th>
                <td>{{isset($cargo->nombre)?$cargo->nombre:'No posee'}}</td>
            </tr>
            <tr>
                <th>Funci&oacute;n:</th>
                <td>{{isset($funcion->nombre)?$funcion->nombre:'No posee'}}</td>
            </tr>
            <tr>
                <th>Funci&oacute;n espec&iacute;fica:</th>
                <td>{{isset($operativo->funcion_especifica)?$operativo->funcion_especifica:'No posee'}}</td>

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
            <tr>
                <th>Rotativo:</th>
                <td>{{($horario->rotativo== true)?'Si' : 'No'}}</td>
            </tr>
            <tr>
                <th>Eximido:</th>
                <td>{{($horario->eximido== true)?'Si' : 'No'}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

