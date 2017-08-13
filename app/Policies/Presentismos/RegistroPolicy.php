<?php

namespace Cat\Policies\Presentismos;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class RegistroPolicy extends SecurityPolicy
{
    
    public function store(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Cargar presentismo individual');
    }
    
    public function update(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar presentismo');
    }
    
    public function comentario(User $user)
    {
        return (
            $this->verifyOnlyControllerPermission($user, 'Cargar presentismo individual')
            or
            $this->verifyOnlyControllerPermission($user, 'Modificar presentismo')
        );
//        return $this->verifyOnlyControllerPermission($user, 'Comentar presentismo');
    }
    
}
