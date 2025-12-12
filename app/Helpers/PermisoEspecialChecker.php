<?php

namespace Cat\Helpers;


use Cat\Modules\Security\Models\Permission;
use Cat\User;
use Illuminate\Support\Facades\Auth;

class PermisoEspecialChecker
{
    static public function check($permiso, User $user = null)
    {
        /** @var Permission $permiso */
        $permiso = Permission::where('name', '=', $permiso)->first();

        $user = $user ? $user : Auth::user();

        return $user->hasAnyPermission($permiso);
    }
}