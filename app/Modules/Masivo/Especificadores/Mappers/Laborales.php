<?php

namespace Cat\Modules\Masivo\Especificadores\Mappers;

use Cat\Modules\Masivo\Helpers\DataCleaner;
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
            'fecha_ingreso'          => DataCleaner::cleanPossibleEmptyDate($collection->fecha_ingreso),
            'fecha_ingreso_gobierno' => DataCleaner::cleanPossibleEmptyDate($collection->fecha_ingreso_gobierno),
            'tipo_inscripcion'       => DataCleaner::cleanPossibleEmptyValue($collection->tipo_inscripcion),
            'id_estado_contrato'     => $estadoContrato->id,
            'id_tipo_contrato'       => $modalidad->id,
            'monto'                  => DataCleaner::cleanPossibleEmptyValue($collection->monto),
            'comentario'             => null,
            'fecha_estado_desde'     => null,
            'fecha_estado_hasta'     => null,
            'fecha_fin'              => null,
        ];
        
    }
    
    
}
