<?php

namespace Cat\Repositories;

use Cat\Models\PresentismoModel;
use InfyOm\Generator\Common\BaseRepository;

class PresentismoModelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_agente',
        'id_jornada',
        'id_tipo_presentismo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PresentismoModel::class;
    }
}
