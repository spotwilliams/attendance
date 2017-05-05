<?php

namespace Cat\Repositories;

use Cat\Models\AgenteModel;
use InfyOm\Generator\Common\BaseRepository;

class AgenteModelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre',
        'apellido',
        'dni',
        'fecha_nacimiento',
        'cuit',
        'id_base',
        'id_area',
        'id_domicilio',
        'id_contrato',
        'id_dias_disponibles',
        'id_estudio'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AgenteModel::class;
    }
}
