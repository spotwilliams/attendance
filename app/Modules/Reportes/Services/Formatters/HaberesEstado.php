<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use Cat\Helpers\Calculation;
use Illuminate\Database\Eloquent\Model;


class HaberesEstado extends RowDataFormatter
{
    public function format(Model $agente)
    {
        return $this->toExcelRow($agente);
    }
    
    protected function toExcelRow(Model $estadoPeriodo)
    {
        $monto = Calculation::getMontoAcumulado($estadoPeriodo->periodo, $estadoPeriodo->base, $estadoPeriodo->turno);
        
        $data  = [
            'Desde'       => (new \DateTime($estadoPeriodo->periodo->fecha_comienzo))->format('d/m/Y'),
            'Hasta'       => (new \DateTime($estadoPeriodo->periodo->fecha_fin))->format('d/m/Y'),
            'Base'        => $estadoPeriodo->base->nombre,
            'Turno'       => $estadoPeriodo->turno->codigo,
            'Monto total' => $monto->total,
        ];
        
        return array_merge($data);
        
        
    }
    
}
