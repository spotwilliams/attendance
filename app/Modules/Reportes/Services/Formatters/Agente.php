<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use Illuminate\Database\Eloquent\Model;


class Agente extends RowDataFormatter
{
    public function format(Model $agente)
    {
        $attributes = [
            'id',
            'id_agente',
            'created_at',
            'updated_at',
            'deleted_at',
            'id_base',
            'id_gerencia',
            'id_turno',
            'id_horario',
            'id_funcion',
            'id_area',
            'id_cargo',
            'id_estado_contrato',
            'id_tipo_contrato',
            'id_padre',
        ];

        return parent::toExcelRow($agente, $attributes);
    }
    
}