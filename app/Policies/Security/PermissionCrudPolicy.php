<?php

namespace Cat\Policies\Security;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class PermissionCrudPolicy  extends SecurityPolicy
{
    
    public function index(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Ver permisos');
    }

    public function create(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Sin permisos');
    }
    
    
    public function edit(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Sin permisos');
    }
    
    
    public function storeCrud(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Sin permisos');
    }
    
    
    public function updateCrud(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Sin permisos');
    }
    
    
    public function destroy(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Sin permisos');
    }
    
    
}
