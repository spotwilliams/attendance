<?php

namespace Cat\Masivo\Especificadores\Mappers;

use Carbon\Carbon;
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
        $subGerencia = Gerencia::find(($collection->subgerencia == '#N/A' ? -1 : $collection->subgerencia));
        
        if ($subGerencia == null) {
            $subGerencia = Gerencia::find(($collection->gerencia == '#N/A' ? -1 : $collection->gerencia));
        }
        
        return [
            'agente'             => $agente->id,
            'id_gerencia'        => ($subGerencia === null) ? -1 : $subGerencia->id,
            'id_base'            => $base->id,
            'id_area'            => $collection->area,
            'id_cargo'           => $collection->cargo,
            'id_funcion'         => $collection->funcion,
            'id_turno'           => $collection->turno,
            'funcion_especifica' => $collection->funcion_especifica,
            'hora_entrada'       => $collection->hora_entrada->format('H:i'),
            'hora_salida'        => $collection->hora_salida->format('H:i'),
            'eximido'            => $collection->eximido,
            'rotativo'           => $collection->rotativo,
        
        ];
        
    }
    
    
}