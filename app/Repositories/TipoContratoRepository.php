<?php

namespace Cat\Repositories;

use Cat\Helpers\Cache;
use Cat\Models\TipoContrato;

class TipoContratoRepository
{
    /**
     *
     * @param bool $cache True: se saca de cache
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public static function getAll($cache = true)
    {
        if ($cache) {
            $bases = Cache::get('all_tipo_contratos', fn() => TipoContrato::all());
        } else {
            $bases = TipoContrato::all();
        }
        return $bases;
    }
}
