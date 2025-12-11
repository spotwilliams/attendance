<?php

namespace Cat\Policies\Configuracion\Areas;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class ConfiguracionPermisosPolicy extends SecurityPolicy
{
    
    public function index(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Configurar permisos');
    }
    
    public function create(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Configurar permisos');
    }
    
    
    public function edit(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Configurar permisos');
    }
    
    
    public function storeCrud(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Configurar permisos');
    }
    
    
    public function updateCrud(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Configurar permisos');
    }
    
    
    public function destroy(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Configurar permisos');
    }
    
}
