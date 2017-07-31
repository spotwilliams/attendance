<?php

namespace Cat\Policies;

use Cat\User;

class CrudAgentePolicy extends SecurityPolicy
{
    
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    
    public function search(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Busqueda de personal');
    }
}
