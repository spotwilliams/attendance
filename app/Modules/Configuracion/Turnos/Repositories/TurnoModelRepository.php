<?php

namespace Cat\Modules\Configuracion\Turnos\Repositories;

use Cat\Models\Turno;
use Cat\Repositories\BaseRepository;

class TurnoModelRepository extends BaseRepository
{
    public function model(): string
    {
        return Turno::class;
    }
}
