<?php

namespace Cat\Policies\Configuracion\Areas;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class CrudPolicy extends SecurityPolicy
{
    
    
    public function create(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Crear area');
    }
    
    public function index(User $user)
    {
        
        return (
            $this->verifyOnlyControllerPermission($user, 'Crear area')
            or
            $this->verifyOnlyControllerPermission($user, 'Modificar area')
        );
    }
    
    
    public function store(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Crear area');
    }
    
    
    public function edit(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar area');
    }
    
    
    public function update(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar area');
    }
    
}
