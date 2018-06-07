<?php

namespace Cat\Modules\Haberes\Controllers\Notificacion;

use Cat\Modules\Haberes\Controllers\Registro\ConfirmarController as ParentController;

class ConfirmarController extends ParentController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->searchView    = 'Haberes::notificacion.seleccionar-agentes';
        $this->indexRoute    = 'notificacionIndex';
        $this->confirmarView = 'Haberes::notificacion.confirmar-montos';
        $this->searchView    = 'Haberes::notificacion.seleccionar-agentes';
        $this->endView       = 'Haberes::notificacion.end';
    }
    
}
