<?php

namespace Cat\Repositories;

use Cat\Models\AreasModel;
use InfyOm\Generator\Common\BaseRepository;

class AreasModelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'direccion',
        'gerencia',
        'subgerencia'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AreasModel::class;
    }
}
