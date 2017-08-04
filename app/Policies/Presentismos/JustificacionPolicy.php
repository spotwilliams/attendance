<?php

namespace Cat\Policies\Presentismos;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class JustificacionPolicy extends SecurityPolicy
{
    
    public function justificar(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Justificar presentismo');
    
    }
    
    public function injustificar(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Injustificar presentismo');
    
    }
}
