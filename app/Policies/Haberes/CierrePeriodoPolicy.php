<?php

namespace Cat\Policies\Haberes;

use Cat\Policies\SecurityPolicy;
use Cat\User;


class CierrePeriodoPolicy extends SecurityPolicy
{
    public function disclaimer(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Cerrar periodo');
    }
    
    public function batch(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Cerrar periodo');
    }
}