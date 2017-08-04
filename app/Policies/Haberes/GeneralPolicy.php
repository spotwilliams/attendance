<?php

namespace Cat\Policies\Haberes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class GeneralPolicy extends SecurityPolicy
{
    public function selectBase(User $user)
    {
        return (
            $this->verifyOnlyControllerPermission($user, 'Reporte haberes')
            or
            $this->verifyOnlyControllerPermission($user, 'Cerrar periodo')
        );
    }
    
    
    public function selectPeriodo(User $user)
    {
        return (
            $this->verifyOnlyControllerPermission($user, 'Reporte haberes')
            or
            $this->verifyOnlyControllerPermission($user, 'Cerrar periodo')
        );
    }
    
    public function prepareListaAgentes(User $user)
    {
        return (
            $this->verifyOnlyControllerPermission($user, 'Reporte haberes')
            or
            $this->verifyOnlyControllerPermission($user, 'Cerrar periodo')
        );
    }
    
    public function listaAgentes(User $user)
    {
        return (
            $this->verifyOnlyControllerPermission($user, 'Reporte haberes')
            or
            $this->verifyOnlyControllerPermission($user, 'Cerrar periodo')
        );
    }
}