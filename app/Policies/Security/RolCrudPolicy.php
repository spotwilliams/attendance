<?php

namespace Cat\Policies\Security;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class RolCrudPolicy extends SecurityPolicy
{
    
    public function index(User $user)
    {
        return (
            $this->verifyOnlyControllerPermission($user, 'Crear rol')
            or
            $this->verifyOnlyControllerPermission($user, 'Editar rol')
        );
    }
    
    public function create(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Crear rol');
    }
    
    
    public function edit(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Editar rol');
    }
    
    
    public function storeCrud(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Crear rol');
    }
    
    
    public function updateCrud(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Editar rol');
    }
    
    
    public function destroy(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Sin permisos');
    }
    
    
}
