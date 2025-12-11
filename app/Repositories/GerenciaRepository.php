<?php

namespace Cat\Repositories;


use Cat\Helpers\Cache;
use Cat\Models\Gerencia;

class GerenciaRepository
{
    /**
     *
     * @param bool $cache True: se saca de cache
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public static function getAll($cache = true)
    {
        if ($cache) {
            $bases = Cache::get('all_gerencias', fn() => Gerencia::all());
        } else {
            $bases = Gerencia::all();
        }
        
        return $bases;
    }
}