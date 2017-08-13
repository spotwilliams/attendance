<?php

namespace Cat\Policies\Agentes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class GeneralPolicy extends SecurityPolicy
{
    public function index(User $user)
    {
        return true;
//        return $this->verifyOnlyControllerPermission($user, 'Alta individual personal');
    }
    
    
    public function show(User $user)
    {
        return true;
//        return $this->verifyOnlyControllerPermission($user, 'Alta individual personal');
    }
}