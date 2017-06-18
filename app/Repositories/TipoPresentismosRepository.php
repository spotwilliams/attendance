<?php

namespace Cat\Repositories;

use Cat\Helpers\Cache;
use Cat\Models\TipoContrato;
use Cat\Models\TipoPresentismo;

class TipoPresentismosRepository
{
    
    /**
     *
     * @param bool $cache True: se saca de cache
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public static function getAll($cache = true)
    {
        if ($cache) {
            $bases = Cache::get('all_tipos_presentismo', function () {
                return TipoPresentismo::all();
            });
        } else {
            $bases = TipoPresentismo::all();
        }
        
        return $bases;
    }
    
    /**
     *
     * @param bool $cache True: se saca de cache
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public static function getByTipoContrato(TipoContrato $tipoContrato, $cache = true)
    {
        $tipoContratoEloquent = TipoPresentismo::where('aplica', '=', $tipoContrato->codigo)
            ->orWhere('aplica', '=', 'TODOS');
        $key                  = $tipoContrato->codigo . '_tipos_presentismo';
        if ($cache) {
            $bases = Cache::get($key, function () use ($tipoContratoEloquent) {
                return $tipoContratoEloquent->get();
            });
        } else {
            $bases = $tipoContratoEloquent->get();
        }
        
        return $bases;
    }
}
