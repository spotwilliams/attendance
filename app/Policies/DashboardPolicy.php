<?php

namespace Cat\Policies;

use Cat\User;

class DashboardPolicy extends SecurityPolicy
{
    /**
     * @param User $user
     * @return bool
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(User $user)
    {
        return  $this->verifyOnlyControllerPermission($user, 'Datos estadisticos inicio');
    }
    
}
