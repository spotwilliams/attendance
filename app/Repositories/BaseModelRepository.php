<?php

namespace App\Repositories;

use App\Models\BaseModel;
use InfyOm\Generator\Common\BaseRepository;

class BaseModelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BaseModel::class;
    }
}
