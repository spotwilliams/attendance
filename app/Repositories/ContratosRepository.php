<?php

namespace App\Repositories;

use App\Models\Contratos;
use Cat\Repositories\BaseRepository;

class ContratosRepository extends BaseRepository
{
    public function model(): string
    {
        return Contratos::class;
    }
}
