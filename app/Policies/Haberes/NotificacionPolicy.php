<?php

namespace Cat\Policies\Haberes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class NotificacionPolicy extends SecurityPolicy
{
    
    /**
     * @param User $user
     * @return bool
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Notificacion de facturacion');
    }
    
    /**
     * @param User $user
     * @return bool
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Notificacion de facturacion');
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function send(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Notificacion de facturacion');
    }
    
}