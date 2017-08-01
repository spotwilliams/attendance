<?php

namespace Cat\Repositories;


use Cat\Helpers\Cache;
use Cat\Models\Area;

class AreaRepository
{
    /**
     *
     * @param bool $cache True: se saca de cache
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public static function getAll($cache = true)
    {
        if ($cache) {
            $bases = Cache::get('all_areas', function () {
                return Area::all();
            });
        } else {
            $bases = Area::all();
        }
        
        return $bases;
    }
}