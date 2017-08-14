<?php

namespace Cat\Policies;

use Cat\User;
use Illuminate\Http\Request;

class RequestPolicy extends SecurityPolicy
{
    public function base(User $user, Request $request)
    {
        $bases = $this->getTheParam($request, 'base');
        if (empty($bases)) {
            return true;
        } else {
            return $this->verifyCanWorkWithBase($user, $bases);
        }
        
    }
    
    public function turno(User $user, Request $request)
    {
        $turnos = $this->getTheParam($request, 'turno');
        if (empty($turnos)) {
            return true;
        } else {
            return $this->verifyCanWorkWithTurno($user, $turnos);
        }
    }
    
    private function getTheParam(Request $request, $what)
    {
        $input  = $request->all();
        $return = null;
        if (isset($input[$what])) {
            $return = $input[$what];
        } elseif (isset($input[$what . 's'])) {
            //plural
            $return = $input[$what . 's'];
        } else {
            $return = [];
        }
        
        if (($return === null) or ((!is_array($return)) and ($return == -1))) {
            $return = [];
        }
        
        return (is_array($return) ? $return : [$return]);
        
    }
}