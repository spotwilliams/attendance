<?php

namespace Cat\Repositories;

use Cat\Helpers\Cache;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;

class TurnosRepository
{
    public static function getAll($cache = true)
    {
        if ($cache) {
            $bases = Cache::get('all_turnos', fn() => Turno::orderBy('codigo', 'ASC')->get());
        } else {
            $bases = Turno::orderBy('codigo', 'ASC')->get();
        }
        
        return $bases;
    }
    
    public static function getOnlyForLocacion()
    {
        /** @var \Illuminate\Database\Query\Builder $eloq */
        $eloq = Turno::select(['turnos.id', 'turnos.codigo']);
        
        $eloq
            ->distinct()
            ->join('operativos', 'turnos.id', '=', 'operativos.id_turno')
            ->join('agentes', 'agentes.id', '=', 'operativos.id_agente')
            ->join('contratos', function ($joinClause): void {
                /** @var \Illuminate\Support\Collection $tipo */
                /** @var \Illuminate\Database\Query\JoinClause $joinClause */
                
                $tipo = TipoContrato::select('id')
                    ->where('codigo', 'LOCACION')
                    ->get();
                
                $joinClause->on('agentes.id', '=', 'contratos.id_agente')
                    ->whereIn('id_tipo_contrato', array_keys($tipo->keyBy('id')->toArray()));
            });
        
        return $eloq;
    }
}
