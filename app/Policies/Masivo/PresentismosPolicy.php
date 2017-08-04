<?php

namespace Cat\Policies\Agentes;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class PresentismosPolicy extends SecurityPolicy
{
    
    public function index(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Cargar presentismo masivo');
    }
    
    public function selectFile(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Cargar presentismo masivo');
    }
    
    public function upload(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Cargar presentismo masivo');
    }
    
    public function downloadErrores(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Cargar presentismo masivo');
    }
    
    public function downloadTemplate(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Cargar presentismo masivo');
    }
}
