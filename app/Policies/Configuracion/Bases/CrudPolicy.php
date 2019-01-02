<?php

namespace Cat\Policies\Configuracion\Bases;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class CrudPolicy extends SecurityPolicy
{
    
    
    public function create(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Crear base');
    }
    
    public function index(User $user)
    {
        
        return (
            $this->verifyOnlyControllerPermission($user, 'Crear base')
            or
            $this->verifyOnlyControllerPermission($user, 'Modificar base')
            or
            $this->verifyOnlyControllerPermission($user, 'Eliminar base')
        );
    }
    
    
    public function store(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Crear base');
    }
    
    
    public function edit(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar base');
    }
    
    
    public function update(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar base');
    }

    public function delete(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Eliminar base');
    }
    
    
    public function destroy(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Eliminar base');
    }
    
}
