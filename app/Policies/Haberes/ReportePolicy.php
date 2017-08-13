<?php

namespace Cat\Policies\Haberes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class ReportePolicy extends SecurityPolicy
{
    public function reporte(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Calcular haberes');
    }
    
    public function reportePreliminar(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Calcular haberes');
    }
}