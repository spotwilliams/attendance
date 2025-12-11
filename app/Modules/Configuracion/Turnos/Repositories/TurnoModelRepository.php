<?php

namespace Cat\Modules\Configuracion\Turnos\Repositories;

use Cat\Models\Turno;
use Cat\Repositories\BaseRepository;

class TurnoModelRepository// extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'codigo',
        'descripcion'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Turno::class;
    }
}
