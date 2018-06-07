<?php

namespace Cat\Modules\Haberes\Controllers\Notificacion;


use Cat\Modules\Haberes\Controllers\Registro\ByFiltrosController as ParentController;

class ByFiltrosController extends ParentController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->searchView = 'Haberes::notificacion.seleccionar-agentes';
        $this->indexRoute = 'searchIndex';
    }
    
}
