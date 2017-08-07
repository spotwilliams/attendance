<?php

namespace Cat\Policies\Reportes\Agentes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class ExportarPolicy extends SecurityPolicy
{
    
    public function export(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Exportar reporte personal');
    }
    
}
