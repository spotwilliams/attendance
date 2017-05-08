<?php

namespace App\Repositories;

use App\Models\Presentismo;
use InfyOm\Generator\Common\BaseRepository;

class PresentismoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_agente',
        'id_jornada',
        'id_tipo_presentismo',
        'id_padre'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Presentismo::class;
    }
}
