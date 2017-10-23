<?php

$haberes = isset($haberes) ? $haberes : [];
?>
@foreach($haberes as $h)
    <tr>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($h, ['agente', 'apellido'])}}
            , {{\Cat\Helpers\ModelCreator::getDataFromModel($h, ['agente', 'nombre'])}}
        </td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($h, ['agente', 'cuit'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($h, ['agente', 'operativo', 'base', 'nombre'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($h, ['agente', 'operativo', 'turno', 'codigo'])}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($h, ['periodo', 'fecha_comienzo'], function($fecha){
            return trans('month.'. (new DateTime($fecha))->format('m'));
        })}}</td>
        <td>{{\Cat\Helpers\ModelCreator::getDataFromModel($h, ['periodo', 'fecha_comienzo'], function($fecha){
            return (new DateTime($fecha))->format('Y');
        })}}</td>
        <td>$ {{\Cat\Helpers\ModelCreator::getDataFromModel($h, ['monto_facturado'])}}</td>
    </tr>
@endforeach