<?php

namespace Cat\Repositories;

use Cat\Helpers\Cache;
use Cat\Models\EstadoContrato;

class EstadoContratoRepository
{
    /**
     *
     * @param bool $cache True: se saca de cache
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public static function getAll($cache = true)
    {
        if ($cache) {
            $bases = Cache::get('all_estado_contratos', fn() => EstadoContrato::all());
        } else {
            $bases = EstadoContrato::all();
        }
        return $bases;
    }
}
