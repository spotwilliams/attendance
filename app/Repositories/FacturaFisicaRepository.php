<?php

namespace Cat\Repositories;

use Cat\Models\FacturaFisica;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FacturaFisicaRepository
 * @package Cat\Repositories
 * @version May 31, 2018, 1:19 pm -03
 *
 * @method FacturaFisica findWithoutFail($id, $columns = ['*'])
 * @method FacturaFisica find($id, $columns = ['*'])
 * @method FacturaFisica first($columns = ['*'])
*/
class FacturaFisicaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_agente',
        'id_periodo',
        'nro_factura'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FacturaFisica::class;
    }
}
