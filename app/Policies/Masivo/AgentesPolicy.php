<?php

namespace Cat\Policies\Masivo;

use Cat\Policies\SecurityPolicy;
use Cat\User;

class AgentesPolicy extends SecurityPolicy
{
    
    public function index(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Cargar personal masivo');
    }
    
    public function upload(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Cargar personal masivo');
    }
    
    public function downloadErrores(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Cargar personal masivo');
    }
    
    
    public function downloadTemplate(User $user)
    {
        return $this->verifyOnlyControllerPermission($user, 'Cargar personal masivo');
    }
}
