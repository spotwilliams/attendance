<?php

namespace Cat\Modules\Security\Helpers;


use Cat\Modules\Security\Models\Permission;
use Cat\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class Checker
{
    static public function hasPermission($permissionName, User $user = null)
    {
        try {
            $permission = Permission::where('name', '=', $permissionName)
                ->firstOrFail();
            if ($user === null) {
                $user = Auth::user();
            }
            
            return $user->hasPermissionTo($permission);
            
        } catch (ModelNotFoundException $n) {
            return false;
        }
    }
}