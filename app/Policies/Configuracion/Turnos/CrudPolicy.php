<?php

namespace Cat\Policies\Configuracion\Turnos;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class CrudPolicy extends SecurityPolicy
{
    
    
    public function create(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Crear turno');
    }
    
    public function index(User $user)
    {
        
        return (
            $this->verifyOnlyControllerPermission($user, 'Crear turno')
            or
            $this->verifyOnlyControllerPermission($user, 'Modificar turno')
            or
            $this->verifyOnlyControllerPermission($user, 'Eliminar turno')
        );
    }
    
    
    public function store(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Crear turno');
    }
    
    
    public function edit(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar turno');
    }
    
    
    public function update(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Modificar turno');
    }
    
    public function delete(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Eliminar turno');
    }
    
    
    public function destroy(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Eliminar turno');
    }
    
}
