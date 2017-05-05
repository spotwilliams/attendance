<?php

namespace Cat\Repositories;

use Cat\Models\DomicilioModel;
use InfyOm\Generator\Common\BaseRepository;

class DomicilioModelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'calle',
        'numero',
        'deptartamento',
        'piso',
        'barrio',
        'provincia',
        'libre'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DomicilioModel::class;
    }
}
