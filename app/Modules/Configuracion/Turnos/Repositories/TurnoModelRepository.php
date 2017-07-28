<?php

namespace Cat\Modules\Configuracion\Turnos\Repositories;

use Cat\Models\Turno;
use InfyOm\Generator\Common\BaseRepository;

class TurnoModelRepository extends BaseRepository
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
