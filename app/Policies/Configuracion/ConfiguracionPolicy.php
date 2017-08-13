<?php

namespace Cat\Policies\Configuracion\Areas;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class ConfiguracionPolicy extends SecurityPolicy
{
    
    
    public function create(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Configurar sistema');
    }
    
    public function index(User $user)
    {
        
        return (
            $this->verifyOnlyControllerPermission($user, 'Configurar sistema')
            or
            $this->verifyOnlyControllerPermission($user, 'Configurar sistema')
        );
    }
    
    
    public function store(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Configurar sistema');
    }
    
    
    public function edit(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Configurar sistema');
    }
    
    
    public function update(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Configurar sistema');
    }
    
}
