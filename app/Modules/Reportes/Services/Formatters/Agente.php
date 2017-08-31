<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use Illuminate\Database\Eloquent\Model;


class Agente extends RowDataFormatter
{
    public function format(Model $agente)
    {
        $attributes = [
            'id'                 => 'N/A',
            'id_agente'          => 'N/A',
            'created_at'         => 'N/A',
            'updated_at'         => 'N/A',
            'deleted_at'         => 'N/A',
            'id_base'            => 'N/A',
            'id_gerencia'        => 'N/A',
            'id_turno'           => 'N/A',
            'id_horario'         => 'N/A',
            'id_funcion'         => 'N/A',
            'id_area'            => 'N/A',
            'id_cargo'           => 'N/A',
            'id_estado_contrato' => 'N/A',
            'id_tipo_contrato'   => 'N/A',
            'id_padre'           => 'N/A',
        ];
        
        return parent::toExcelRow($agente, $attributes);
    }
    
}