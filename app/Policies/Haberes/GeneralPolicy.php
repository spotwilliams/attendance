<?php

namespace Cat\Policies\Haberes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class GeneralPolicy extends SecurityPolicy
{
    public function selectBase(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Calcular haberes');
    }
    
    
    public function selectPeriodo(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Calcular haberes');
        
    }
    
    public function prepareListaAgentes(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Calcular haberes');
        
    }
    
    public function listaAgentes(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Calcular haberes');
        
    }
}