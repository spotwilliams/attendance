<?php

namespace Cat\Policies\Agentes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class CrudLaboralesPolicy extends SecurityPolicy
{
    
    
    public function create(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Guardar datos laborales');
    }
    
    
    public function store(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Guardar datos laborales');
    }
    
    public function edit(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar datos laborales');
    }

    public function update(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar datos laborales');
    }
    
    public function destroy(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Eliminar datos laborales');
    }
}
