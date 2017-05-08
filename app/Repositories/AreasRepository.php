<?php

namespace App\Repositories;

use App\Models\Areas;
use InfyOm\Generator\Common\BaseRepository;

class AreasRepository extends BaseRepository
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
        return Areas::class;
    }
}
