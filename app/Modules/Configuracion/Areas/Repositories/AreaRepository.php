<?php

namespace Cat\Modules\Configuracion\Areas\Repositories;

use Cat\Models\Area;
use InfyOm\Generator\Common\BaseRepository;

class AreaRepository extends BaseRepository
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
        return Area::class;
    }
}
