<?php

namespace Cat\Repositories;

use Cat\Helpers\Cache;
use Cat\Models\Cargo;

class CargoRepository
{
    /**
     *
     * @param bool $cache True: se saca de cache
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public static function getAll($cache = true)
    {
        if ($cache) {
            $bases = Cache::get('all_cargos', fn() => Cargo::all());
        } else {
            $bases = Cargo::all();
        }
        return $bases;
    }
}
