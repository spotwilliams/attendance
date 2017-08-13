<?php

namespace Cat\Policies\Presentismos;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class PorAgentePolicy extends SecurityPolicy
{
    
    public function index(User $user)
    {
        return (
            $this->verifyOnlyControllerPermission($user, 'Cargar presentismo individual')
            or
            $this->verifyOnlyControllerPermission($user, 'Modificar presentismo')
        );
    }
    
    public function prepareIndividualAgente(User $user)
    {
        return (
            $this->verifyOnlyControllerPermission($user, 'Cargar presentismo individual')
            or
            $this->verifyOnlyControllerPermission($user, 'Modificar presentismo')
        );
    }
    
    public function search(User $user)
    {
        return (
            $this->verifyOnlyControllerPermission($user, 'Cargar presentismo individual')
            or
            $this->verifyOnlyControllerPermission($user, 'Modificar presentismo')
        );
    }
    
}
