<?php

namespace Cat\Repositories;

use Cat\Helpers\Cache;
use Cat\Models\Base;
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
}
