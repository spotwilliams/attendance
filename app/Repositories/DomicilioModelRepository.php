<?php

namespace App\Repositories;

use App\Models\DomicilioModel;
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
