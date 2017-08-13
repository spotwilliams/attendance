<?php

namespace Cat\Policies\Presentismos;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class GeneralPolicy extends SecurityPolicy
{
    
    public function index(User $user)
    {
        return (
            $this->verifyOnlyControllerPermission($user, 'Modificar presentismo')
            or
            $this->verifyOnlyControllerPermission($user, 'Cargar presentismo individual')
        );
    }
    
    public function prepareListaAgentes(User $user)
    {
        return (
            $this->verifyOnlyControllerPermission($user, 'Modificar presentismo')
            or
            $this->verifyOnlyControllerPermission($user, 'Cargar presentismo individual')
        );
    }
}
