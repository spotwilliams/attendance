<?php

namespace Cat\Masivo\Especificadores\Mappers;

use Cat\Models\EstadoContrato;
use Cat\Models\TipoContrato;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Maatwebsite\Excel\Collections\CellCollection;

class Laborales
{
    
    public static function toInput(CellCollection $collection)
    {
        $estadoContrato = EstadoContrato::where('estado', '=', $collection->estado_contrato)
            ->orWhere('descripcion', '=', $collection->estado_contrato)
            ->firstOrFail(['id']);
        
        $modalidad = TipoContrato::where('codigo', '=', $collection->modalidad_contractual)
            ->orWhere('descripcion', '=', $collection->modalidad_contractual)
            ->firstOrFail(['id']);
        
        return [
            'id_sial'            => $collection->id_sial,
            'ficha'              => $collection->ficha,
            'fecha_ingreso'      => $modalidad->fecha_ingreso,
            'id_estado_contrato' => $estadoContrato->id,
            'id_tipo_contrato'   => $modalidad->id,
        ];
        
    }
    
    
}