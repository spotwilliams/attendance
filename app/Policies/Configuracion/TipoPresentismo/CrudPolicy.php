<?php

namespace Cat\Policies\Configuracion\TipoPresentismo;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class CrudPolicy extends SecurityPolicy
{
    
    
    public function create(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Crear  tipo presentismo');
    }
    
    public function index(User $user)
    {
        return (
            $this->verifyOnlyControllerPermission($user, 'Crear tipo presentismo')
            or
            $this->verifyOnlyControllerPermission($user, 'Modificar tipo presentismo')
        );
    }
    
    
    public function store(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Crear tipo presentismo');
    }
    
    
    public function edit(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar tipo presentismo');
    }
    
    
    public function update(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar tipo presentismo');
    }
    
}
