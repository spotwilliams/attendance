<?php

namespace Cat\Modules\Haberes\Controllers\Notificacion;

use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Modules\Haberes\Controllers\Registro\ByAgenteController as ParentController;
use Illuminate\Http\Request;

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
    
    /**
     * @param Request $request
     * @return $this|\Illuminate\Support\Facades\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(Request $request)
    {
        $this->authorize('search', $this);
        
        return parent::search($request);
    }
    
    
}
