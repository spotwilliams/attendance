<?php

namespace Cat\Modules\Security\Models;

use Cat\Models\Base;
use Cat\Models\Turno;
use Cat\Modules\Security\Panel\Traits\CrudTrait;
use Spatie\Permission\Models\Role as OriginalRole;

class Role extends OriginalRole
{
    use CrudTrait;
    
    protected $fillable = ['name', 'guard_name', 'updated_at', 'created_at'];
    
    public function bases()
    {
        return $this->belongsToMany(Base::class, 'base_roles', 'role_id', 'base_id');
    }
    
    public function turnos()
    {
        return $this->belongsToMany(Turno::class, 'turno_roles', 'role_id', 'turno_id');
    }
}
