<?php

namespace App\Repositories;

use App\Models\DiaDisponible;
use InfyOm\Generator\Common\BaseRepository;

class DiaDisponibleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_tipo_presentismo',
        'cant_dias'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DiaDisponible::class;
    }
}
