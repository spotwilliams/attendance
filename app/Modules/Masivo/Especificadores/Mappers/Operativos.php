<?php

namespace Cat\Masivo\Especificadores\Mappers;

use Carbon\Carbon;
use Cat\Masivo\Helpers\DataCleaner;
use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Gerencia;
use Maatwebsite\Excel\Collections\CellCollection;

class Operativos
{
    
    public static function toInput(CellCollection $collection, Agente $agente, Base $base)
    {
        /**
         * Opcionales
         */
        $subGerencia = Gerencia::find(DataCleaner::cleanPossibleEmptyValue($collection->subgerencia, true));
        
        if ($subGerencia == null) {
            $subGerencia = Gerencia::find(DataCleaner::cleanPossibleEmptyValue($collection->gerencia, true));
        }
        
        return [
            'agente'             => DataCleaner::cleanPossibleEmptyValue($agente->id, true),
            'id_gerencia'        => ($subGerencia === null) ? -1 : $subGerencia->id,
            'id_base'            => DataCleaner::cleanPossibleEmptyValue($base->id, true),
            'id_area'            => DataCleaner::cleanPossibleEmptyValue($collection->area, true),
            'id_cargo'           => DataCleaner::cleanPossibleEmptyValue($collection->cargo, true),
            'id_funcion'         => DataCleaner::cleanPossibleEmptyValue($collection->funcion, true),
            'id_turno'           => DataCleaner::cleanPossibleEmptyValue($collection->turno, true),
            'funcion_especifica' => DataCleaner::cleanPossibleEmptyValue($collection->funcion_especifica),
            'hora_entrada'       => DataCleaner::cleanPossibleEmptyValue($collection->hora_entrada),
            'hora_salida'        => DataCleaner::cleanPossibleEmptyValue($collection->hora_salida),
            'eximido'            => DataCleaner::cleanPossibleEmptyValue($collection->eximido),
            'rotativo'           => DataCleaner::cleanPossibleEmptyValue($collection->rotativo),
        
        ];
        
    }
    
    
}