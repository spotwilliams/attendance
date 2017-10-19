<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class Haberes extends RowDataFormatter
{
    public function format(Model $agente)
    {
        return $this->toExcelRow($agente);
    }
    
    protected function toExcelRow(Model $haber)
    {
        $data = [
            'Apellido'              => $haber->agente->apellido,
            'Nombre'                => $haber->agente->nombre,
            'CUIT'                  => $haber->agente->cuit,
            'Base durante periodo'  => $haber->base->nombre,
            'Turno durante periodo' => $haber->turno->codigo,
            'Base actual'           => $haber->agente->operativo->base->nombre,
            'Turno actual'          => $haber->agente->operativo->turno->codigo,
            'Mes'                   => trans('month.'.(new \DateTime($haber->periodo->fecha_comienzo))->format('m')),
            'Año'                   => (new \DateTime($haber->periodo->fecha_comienzo))->format('Y'),
            'Monto'                 => $haber->monto_facturado,
        ];
        
        return array_merge($data);
        
        
    }
    
}