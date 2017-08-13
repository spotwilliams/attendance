<?php

namespace Cat\Policies\Haberes;

use Cat\Policies\SecurityPolicy;
use Cat\User;


class CierrePeriodoPolicy extends SecurityPolicy
{
    public function disclaimer(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Calcular haberes');
    }
    
    public function batch(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Calcular haberes');
    }
}