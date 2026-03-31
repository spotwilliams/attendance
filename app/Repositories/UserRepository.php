<?php

namespace Cat\Repositories;

use Cat\Modules\Security\Models\BaseRole;
use Cat\Modules\Security\Models\TurnoRole;
use Cat\User;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository
{
    public function model(): string
    {
        return User::class;
    }

    public static function getBasesAllowed($baseIds)
    {
        $baseIds     = (is_array($baseIds) ? $baseIds : [$baseIds]);
        $user        = Auth::user();
        $rolesOfUser = (array_keys($user->roles()->get()->keyBy('id')->toArray()));
        
        $basesAllowed = BaseRole::select(['bases.id'])
            ->whereIn('role_id', $rolesOfUser)
            ->join('bases', 'base_roles.base_id', '=', 'bases.id')
            ->whereIn('bases.id', $baseIds)
            ->get()
            ->keyBy('id')
            ->toArray();

        return array_keys($basesAllowed);
        
    }
    
    public static function getTurnosAllowed($turnosIds)
    {
        $turnosIds   = (is_array($turnosIds) ? $turnosIds : [$turnosIds]);
        $user        = Auth::user();
        $rolesOfUser = (array_keys($user->roles()->get()->keyBy('id')->toArray()));
        
        $turnosAllowed = TurnoRole::select(['turnos.id'])
            ->whereIn('role_id', $rolesOfUser)
            ->join('turnos', 'turno_roles.turno_id', '=', 'turnos.id')
            ->whereIn('turnos.id', $turnosIds)
            ->get()
            ->keyBy('id')
            ->toArray();

        return array_keys($turnosAllowed);
        
    }
}
