<?php

namespace Cat\Policies\Presentismos;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class RegistroPolicy extends SecurityPolicy
{
    
    public function store(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Registrar presentismo');
    }
    
    public function update(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar presentismo');
    }
    
    public function comentario(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Comentar presentismo');
    }

}
