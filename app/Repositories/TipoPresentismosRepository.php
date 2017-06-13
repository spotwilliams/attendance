<?php

namespace Cat\Repositories;

use Cat\Helpers\Cache;
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
}
