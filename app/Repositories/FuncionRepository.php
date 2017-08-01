<?php

namespace Cat\Repositories;

use Cat\Helpers\Cache;
use Cat\Models\Funcion;

class FuncionRepository
{
    /**
     *
     * @param bool $cache True: se saca de cache
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public static function getAll($cache = true)
    {
        if ($cache) {
            $bases = Cache::get('all_funciones', function () {
                return Funcion::all();
            });
        } else {
            $bases = Funcion::all();
        }
        
        return $bases;
    }
}