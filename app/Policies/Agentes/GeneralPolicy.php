<?php

namespace Cat\Policies\Agentes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class GeneralPolicy extends SecurityPolicy
{
    public function index(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Listar personal por base');
    }
    
    
    public function show(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Ver ficha de personal');
    }
}