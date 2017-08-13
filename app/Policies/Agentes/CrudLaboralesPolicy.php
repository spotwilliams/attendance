<?php

namespace Cat\Policies\Agentes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class CrudLaboralesPolicy extends SecurityPolicy
{
    
    
    public function create(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Alta individual personal');
    }
    
    
    public function store(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Alta individual personal');
    }
    
    public function edit(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar personal individual');
    }

    public function update(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar personal individual');
    }
    
    public function destroy(User $user)
    {
        return false;
//        return $this->verifyOnlyControllerPermission($user, 'Alta individual personal');
    }
}
