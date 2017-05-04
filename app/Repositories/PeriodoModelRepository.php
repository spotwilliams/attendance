<?php

namespace App\Repositories;

use App\Models\PeriodoModel;
use InfyOm\Generator\Common\BaseRepository;

class PeriodoModelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'fecha_comienzo',
        'fecha_fin',
        'cant_dias'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PeriodoModel::class;
    }
}
