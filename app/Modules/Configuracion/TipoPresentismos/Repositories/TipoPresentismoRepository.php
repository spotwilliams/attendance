<?php

namespace Cat\Modules\Configuracion\TipoPresentismos\Repositories;

use Cat\Models\TipoPresentismo;
use Cat\Repositories\BaseRepository;

class TipoPresentismoRepository extends BaseRepository
{
    public function model(): string
    {
        return TipoPresentismo::class;
    }
}
