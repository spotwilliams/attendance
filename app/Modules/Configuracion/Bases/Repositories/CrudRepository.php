<?php

namespace Cat\Modules\Configuracion\Bases\Repositories;

use Cat\Models\Base;
use Cat\Repositories\BaseRepository;

class CrudRepository extends BaseRepository
{
    public function model(): string
    {
        return Base::class;
    }
}
