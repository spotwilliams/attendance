<?php

namespace Cat\Policies\Reportes\Agentes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class ReportePolicy extends SecurityPolicy
{
    
    public function index(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Ver y Exportar Reportes');
    }
    
    public function search(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Ver y Exportar Reportes');
    }
    
}
