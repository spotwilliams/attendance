<?php

namespace Cat\Masivo\Especificadores\Mappers;

use Cat\Models\Agente;
use Cat\Models\Area;
use Cat\Models\Base;
use Cat\Models\Cargo;
use Cat\Models\Funcion;
use Cat\Models\Gerencia;
use Cat\Models\Horario;
use Cat\Models\Turno;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Collections\CellCollection;

class Operativos
{
    
    public static function toInput(CellCollection $collection, Agente $agente, Base $base)
    {
        
        
        // gerencia	subgerencia
        
        /**
         * Obligatorios
         */
        $funcion = Funcion::where('nombre', '=', $collection->funcion)
            ->firstOrFail(['id']);
        
        $turno = Turno::where('codigo', '=', $collection->turno)
            ->orWhere('descripcion', '=', $collection->turno)
            ->firstOrFail(['id']);
        
        $horario = Horario::where('hora_entrada', '=', $collection->hora_entrada)
            ->where('hora_salida', '=', $collection->hora_salida)
            ->firstOrFail(['id']);
        
        
        /**
         * Opcionales
         */
        $area = Area::where('nombre', '=', $collection->base)
            ->first([DB::raw('IFNULL(id,-1) as id')]);
        
        $cargo = Cargo::where('nombre', '=', $collection->base)
            ->first([DB::raw('IFNULL(id,-1) as id')]);
        
        $subGerencia = Gerencia::where('nombre', '=', $collection->subgerencia)
            ->first([DB::raw('IFNULL(id,-1) as id')]);
        
        if ($subGerencia == null) {
            $subGerencia = Gerencia::where('nombre', '=', $collection->gerencia)
                ->first([DB::raw('IFNULL(id,-1) as id')]);
        }
        
        return [
            'agente'      => $agente->id,
            'id_gerencia' => ($subGerencia === null) ? -1 : $subGerencia->id,
            'id_base'     => $base->id,
            'id_area'     => ($area === null) ? -1 : $area->id,
            'id_cargo'    => ($cargo === null) ? -1 : $cargo->id,
            'id_funcion'  => $funcion->id,
            'id_turno'    => $turno->id,
            'id_horario'  => $horario->id,
        
        ];
        
    }
    
    
}