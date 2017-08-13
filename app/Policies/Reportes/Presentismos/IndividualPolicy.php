<?php

namespace Cat\Policies\Reportes\Presentismos;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class IndividualPolicy extends SecurityPolicy
{
    
    public function index(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Ver y Exportar Reportes');
    }
    
    public function search(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Ver y Exportar Reportes');
    }
    
    public function prepareIndividualAgente(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Ver y Exportar Reportes');
    }
    
    public function reporte(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Ver y Exportar Reportes');
    }
    
    public function export(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Ver y Exportar Reportes');
    }
}

