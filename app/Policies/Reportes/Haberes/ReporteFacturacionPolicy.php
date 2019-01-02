<?php

namespace Cat\Policies\Reportes\Haberes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class ReporteFacturacionPolicy extends SecurityPolicy
{
    /**
     * @param User $user
     * @return bool
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Reporte de facturacion');
    }
    
    /**
     * @param User $user
     * @return bool
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Reporte de facturacion');
    }
    
    /**
     * @param User $user
     * @return bool
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function export(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Reporte de facturacion');
    }
}
