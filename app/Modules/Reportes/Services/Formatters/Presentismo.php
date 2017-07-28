<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Presentismo extends RowDataFormatter
{
    public function format(Model $agente)
    {
        $attributes   = [
            'id',
            'id_agente',
            'fecha_nacimiento',
            'sexo',
            'estado_civil',
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
            'id_tipo_presentismo',
            'id_periodo',
        ];
        $relations    = [
            'operativo',
            'contrato',
        ];
        $presentismos = $this->transformPresentismo($agente->presentismos);

        $agente->setRelation('presentismos', $presentismos);

        return parent::toExcelRow($agente, $attributes, $relations);
    }
    
    private function transformPresentismo(Collection $presentismos)
    {
        $pres = [];
        foreach ($presentismos as $p) {
            $pres[$p->fecha] = $p->tipoPresentismo->codigo . '(' . $p->tipoPresentismo->descripcion . ') - ' . (($p->injustificado == true) ? 'Injustificado' : 'Justificado');
        }
        
        return new Collection($pres);
    }
}