<?php

namespace Cat\Policies\Reportes\Presentismos;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class ExportarPolicy extends SecurityPolicy
{
    
    public function export(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Ver y Exportar Reportes');
    }
    
}
