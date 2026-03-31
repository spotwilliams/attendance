<?php

namespace Cat\Repositories;

use Cat\Models\FacturaFisica;
use Cat\Repositories\BaseRepository;

class FacturaFisicaRepository extends BaseRepository
{
    public function model(): string
    {
        return FacturaFisica::class;
    }
}
