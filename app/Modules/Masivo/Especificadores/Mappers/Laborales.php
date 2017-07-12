<?php

namespace Cat\Masivo\Especificadores\Mappers;

use Cat\Masivo\Helpers\DataCleaner;
use Cat\Models\EstadoContrato;
use Cat\Models\TipoContrato;
use Maatwebsite\Excel\Collections\CellCollection;

class Laborales
{
    
    public static function toInput(CellCollection $collection)
    {
        $estadoContrato = EstadoContrato::findOrFail(DataCleaner::cleanPossibleEmptyValue($collection->estado_contrato));
        $modalidad      = TipoContrato::findOrFail(DataCleaner::cleanPossibleEmptyValue($collection->modalidad_contractual));
        
        return [
            'id_sial'                => DataCleaner::cleanPossibleEmptyValue($collection->id_sial),
            'ficha'                  => DataCleaner::cleanPossibleEmptyValue($collection->ficha),
            'fecha_ingreso'          => DataCleaner::cleanPossibleEmptyDate($modalidad->fecha_ingreso),
            'fecha_ingreso_gobierno' => DataCleaner::cleanPossibleEmptyDate($modalidad->fecha_ingreso_gobierno),
            'tipo_inscripcion'       => DataCleaner::cleanPossibleEmptyValue($modalidad->tipo_inscripcion),
            'id_estado_contrato'     => DataCleaner::cleanPossibleEmptyValue($estadoContrato->id, true),
            'id_tipo_contrato'       => DataCleaner::cleanPossibleEmptyValue($modalidad->id, true),
            'monto'                  => DataCleaner::cleanPossibleEmptyValue($modalidad->monto),
        ];
        
    }
    
    
}