<?php

namespace Cat\Modules\Configuracion\Bases\Repositories;

use Cat\Models\Base;
use Cat\Repositories\BaseRepository;

class CrudRepository extends BaseRepository
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
        return Base::class;
    }
}
