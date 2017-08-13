<?php

namespace Cat\Policies\Agentes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class SearchAgentePolicy extends SecurityPolicy
{
    
    public function search(User $user)
    {
        return true;
//        return $this->verifyOnlyControllerPermission($user, 'Buscar personal');
    }
}
