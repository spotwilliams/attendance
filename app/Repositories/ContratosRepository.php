<?php

namespace App\Repositories;

use App\Models\Contratos;
use InfyOm\Generator\Common\BaseRepository;

class ContratosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tipo_contrato',
        'fecha_firma',
        'fecha_comienzo',
        'id_estado_contrato'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Contratos::class;
    }
}
