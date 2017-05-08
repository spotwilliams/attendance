<?php

namespace App\Repositories;

use App\Models\Agente;
use InfyOm\Generator\Common\BaseRepository;

class AgenteRepository extends BaseRepository
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
        return Agente::class;
    }
}
