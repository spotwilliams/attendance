<?php

namespace App\Repositories;

use App\Models\Periodo;
use InfyOm\Generator\Common\BaseRepository;

class PeriodoRepository extends BaseRepository
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
        return Periodo::class;
    }
}
