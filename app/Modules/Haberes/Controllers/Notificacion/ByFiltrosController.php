<?php

namespace Cat\Modules\Haberes\Controllers\Notificacion;


use Cat\Modules\Haberes\Controllers\Registro\ByFiltrosController as ParentController;
use Illuminate\Http\Request;

class ByFiltrosController extends ParentController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->searchView = 'Haberes::notificacion.seleccionar-agentes';
        $this->indexRoute = 'searchIndex';
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Support\Facades\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(Request $request)
    {
        $this->authorize('search', $this);
        
        return parent::search($request);
    }
}
