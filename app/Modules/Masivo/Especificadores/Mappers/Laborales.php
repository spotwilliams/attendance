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
        $estadoContrato = EstadoContrato::findOrFail($collection->estado_contrato);
        
        $modalidad = TipoContrato::findOrFail($collection->modalidad_contractual);
        
        return [
            'id_sial'                => $collection->id_sial,
            'ficha'                  => $collection->ficha,
            'fecha_ingreso'          => $modalidad->fecha_ingreso,
            'fecha_ingreso_gobierno' => $modalidad->fecha_ingreso_gobierno,
            'tipo_inscripcion'       => $modalidad->tipo_inscripcion,
            'id_estado_contrato'     => $estadoContrato->id,
            'id_tipo_contrato'       => $modalidad->id,
            'monto'                  => $modalidad->monto,
        ];
        
    }
    
    
}