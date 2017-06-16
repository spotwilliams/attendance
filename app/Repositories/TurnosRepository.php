<?php

namespace Cat\Repositories;

use Cat\Helpers\Cache;
use Cat\Models\Turno;

class TurnosRepository
{
    public static function getAll($cache = true)
    {
        if ($cache) {
            $bases = Cache::get('all_turnos', function () {
                return Turno::all();
            });
        } else {
            $bases = Turno::all();
        }
        
        return $bases;
    }
}
