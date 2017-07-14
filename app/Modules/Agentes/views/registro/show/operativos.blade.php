<?php
use Cat\Helpers\ModelCreator;
use Cat\Models\Operativo;

/** @var \Cat\Models\Agente $agente */

/** @var \Cat\Models\Operativo $operativo */
$operativo = ModelCreator::getModelFromRelation($agente, 'operativo', Operativo::class);

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
$area = ModelCreator::getModelFromRelation($operativo, 'area', \Cat\Models\Area::class);

/** @var \Cat\Models\Cargo $cargo */
$cargo = ModelCreator::getModelFromRelation($operativo, 'cargo', \Cat\Models\Cargo::class);

/** @var \Cat\Models\Funcion $funcion */
$funcion = ModelCreator::getModelFromRelation($operativo, 'funcion', \Cat\Models\Funcion::class);

/** @var \Cat\Models\Horario $horario */
$horario = ModelCreator::getModelFromRelation($operativo, 'horario', \Cat\Models\Horario::class);

/** @var \Cat\Models\Base $base */
$base = ModelCreator::getModelFromRelation($operativo, 'base', \Cat\Models\Base::class);;

/** @var \Cat\Models\Turno $turno */
$turno = ModelCreator::getModelFromRelation($operativo, 'turno', \Cat\Models\Turno::class);;


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

