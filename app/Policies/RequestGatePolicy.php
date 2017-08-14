<?php

namespace Cat\Policies;

use Cat\User;
use Illuminate\Http\Request;

class RequestGatePolicy extends SecurityPolicy
{
    public function base(User $user, array $basesIds)
    {
        return $this->verifyCanWorkWithBase($user, $basesIds);
    }
    
    public function turno(User $user, array $turnoIds)
    {
        return $this->verifyCanWorkWithTurno($user, $turnoIds);
    }
    
}