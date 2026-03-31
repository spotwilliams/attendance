<?php

namespace Cat\Modules\Configuracion\Areas\Repositories;

use Cat\Models\Area;
use Cat\Repositories\BaseRepository;

class AreaRepository extends BaseRepository
{
    public function model(): string
    {
        return Area::class;
    }
}
