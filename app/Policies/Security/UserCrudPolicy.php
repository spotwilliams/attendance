<?php

namespace Cat\Policies\Security;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class UserCrudPolicy extends SecurityPolicy
{
    
    public function index(User $user)
    {
        return (
            $this->verifyOnlyControllerPermission($user, 'Crear usuario')
            or
            $this->verifyOnlyControllerPermission($user, 'Editar usuario')
        );
    }
    
    public function create(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Crear usuario');
    }
    
    
    public function edit(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Editar usuario');
    }
    
    
    public function storeCrud(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Crear usuario');
    }
    
    
    public function updateCrud(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Editar usuario');
    }
    
    
    public function destroy(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Sin permisos');
    }
    
    
}
