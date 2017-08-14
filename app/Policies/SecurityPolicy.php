<?php

namespace Cat\Policies;

use Cat\Modules\Security\Models\BaseRole;
use Cat\Modules\Security\Models\Permission;
use Cat\Modules\Security\Models\TurnoRole;
use Cat\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laracasts\Flash\Flash;

abstract class SecurityPolicy
{
    use HandlesAuthorization;
    
    protected $specialPermissions;
    
    public function __construct(array $specialPermissions = [])
    {
        $this->specialPermissions = $specialPermissions;
    }
    
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
    
    /**
     * @param User $user
     * @param array $baseIds
     * @return bool
     * @throws AuthorizationException
     */
    protected function verifyCanWorkWithBase(User $user, array $baseIds)
    {
        try {
            
            $rolesOfUser = (array_keys($user->roles()->get()->keyBy('id')->toArray()));
            
            $theBase = BaseRole::whereIn('role_id', $rolesOfUser)
                ->join('bases', 'base_roles.base_id', '=', 'bases.id')
                ->whereIn('bases.id',  $baseIds);
            
            $base = $theBase->firstOrFail();
            // Si no falla entonces el user tiene esa base via sus roles
            return true;
            
        } catch (ModelNotFoundException $noExistePermiso) {
            Flash::error('El usuario no tiene acceso para trabajar con una o alguna de las bases seleccionadas');
            throw new AuthorizationException('No existe la base para alguno de los roles del usuario');
        } catch (\Exception $e) {
            throw new AuthorizationException($e->getMessage());
        }
    }

    protected function verifyCanWorkWithTurno(User $user, array $turnoIds)
    {
        try {
            
            $rolesOfUser = (array_keys($user->roles()->get()->keyBy('id')->toArray()));
            
            $theTurno = TurnoRole::whereIn('role_id', $rolesOfUser)
                ->join('turnos', 'turno_roles.turno_id', '=', 'turnos.id')
                ->whereIn('turnos.id',  $turnoIds);
            
            $turno = $theTurno->firstOrFail();
            // Si no falla entonces el user tiene esa base via sus roles
            return true;
            
        } catch (ModelNotFoundException $noExistePermiso) {
            Flash::error('El usuario no acceso para trabajar con uno o alguno de las turnos seleccionados');
    
            throw new AuthorizationException('No existe la base para alguno de los roles del usuario');
        } catch (\Exception $e) {
            throw new AuthorizationException($e->getMessage());
        }
    }
}
