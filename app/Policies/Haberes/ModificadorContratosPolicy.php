<?php

namespace Cat\Policies\Haberes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class ModificadorContratosPolicy extends SecurityPolicy
{
    public function index(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar contratos');
    }
    
    public function update(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar contratos');
    }
}