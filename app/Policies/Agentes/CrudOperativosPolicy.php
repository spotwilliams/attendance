<?php

namespace Cat\Policies\Agentes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class CrudOperativosPolicy extends SecurityPolicy
{
    
    public function create(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Guardar datos operativos');
    }
    
    
    public function store(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Guardar datos operativos');
    }
    
    
    public function edit(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Guardar datos operativos');
    }
    
    
    public function update(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Guardar datos operativos');
    }
    
    
    
    public function destroy(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Guardar datos operativos');
    }
}
