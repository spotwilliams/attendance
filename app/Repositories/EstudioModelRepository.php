<?php

namespace App\Repositories;

use App\Models\EstudioModel;
use InfyOm\Generator\Common\BaseRepository;

class EstudioModelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'institucion',
        'carrera',
        'estado',
        'comentario'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EstudioModel::class;
    }
}
