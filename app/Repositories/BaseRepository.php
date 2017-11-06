<?php

namespace Cat\Repositories;

use Cat\Helpers\Cache;
use Cat\Models\Base;
use Cat\Models\TipoContrato;
use Illuminate\Support\Facades\Auth;

class BaseRepository
{
    
    /**
     *
     * @param bool $cache True: se saca de cache
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public static function getAll($cache = true)
    {
        if ($cache) {
            $bases = Cache::get('all_bases', function () {
                return Base::all();
            });
        } else {
            $bases = Base::all();
        }
        
        return $bases;
    }
    
    
    public static function getOnlyForLocacion()
    {
        /** @var \Illuminate\Database\Query\Builder $eloq */
        $eloq = Base::select(['bases.id', 'bases.nombre']);
        
        $eloq
            ->distinct()
            ->join('operativos', 'bases.id', '=', 'operativos.id_base')
            ->join('agentes', 'agentes.id', '=', 'operativos.id_agente')
            ->join('contratos', function ($joinClause) {
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
