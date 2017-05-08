<?php

namespace App\Repositories;

use App\Models\JornadaLaborable;
use InfyOm\Generator\Common\BaseRepository;

class JornadaLaborableRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'fecha',
        'id_periodo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return JornadaLaborable::class;
    }
}
