<?php

namespace Cat\Modules\Haberes\Controllers\Notificacion;

use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Modules\Haberes\Controllers\Registro\ByAgenteController as ParentController;

class ByAgenteController extends ParentController
{
    
    /** @var string */
    protected $searchView;
    
    /** @var string */
    protected $indexRoute;
    
    public function __construct(AgenteRepository $agenteRepo)
    {
        parent::__construct($agenteRepo);
        
        $this->searchView = 'Haberes::notificacion.seleccionar-agentes';
        $this->indexRoute = 'notificacionIndex';
    }
    
    
}
