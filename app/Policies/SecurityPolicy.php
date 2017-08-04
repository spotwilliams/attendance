<?php

namespace Cat\Policies;

use Cat\Security\Models\Permission;
use Cat\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class SecurityPolicy
{
    use HandlesAuthorization;
    
    
    protected function findPermission($name)
    {
        return Permission::where('name', '=', $name)
            ->firstOrFail();
    }
    
    /**
     * @param User $user
     * @param $namePermission
     * @return bool
     * @throws AuthorizationException
     */
    protected function verifyOnlyControllerPermission(User $user, $namePermission)
    {
        try {
            return $user->hasPermissionTo($this->findPermission($namePermission));
        } catch (ModelNotFoundException $noExistePermiso) {
            
            throw new AuthorizationException('Intenta acceder con permiso inexistente');
        } catch (\Exception $e) {
            throw new AuthorizationException($e->getMessage());
        }
    }
}
