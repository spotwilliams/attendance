<?php

namespace Cat\Policies\Reportes\Haberes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class ReportePolicy extends SecurityPolicy
{
    
    public function index(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Reporte de haberes');
    }
    
    public function search(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Reporte de haberes');
    }
    
}
