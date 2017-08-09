<?php

namespace Cat\Modules\Configuracion\TipoPresentismos\Repositories;

use Cat\Models\TipoPresentismo;
use InfyOm\Generator\Common\BaseRepository;

class TipoPresentismoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'codigo',
        'descripcion',
        'color',
        'aplica',
        'injustificado',
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TipoPresentismo::class;
    }
}
