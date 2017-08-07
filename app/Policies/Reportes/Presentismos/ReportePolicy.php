<?php

namespace Cat\Policies\Reportes\Presentismos;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class ReportePolicy extends SecurityPolicy
{
    
    public function index(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Reporte presentismos');
    }
    
    public function search(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Reporte presentismos');
    }
    
}
