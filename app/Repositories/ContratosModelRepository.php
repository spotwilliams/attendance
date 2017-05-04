<?php

namespace App\Repositories;

use App\Models\ContratosModel;
use InfyOm\Generator\Common\BaseRepository;

class ContratosModelRepository extends BaseRepository
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
        return ContratosModel::class;
    }
}
