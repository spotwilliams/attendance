<?php

namespace Database\Seeders\Security;

use Cat\Models\Base;
use Cat\Models\Turno;
use Cat\Modules\Security\Models\Permission;
use Cat\Modules\Security\Models\Role;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run()
    {
        /** @var Role $rol */
        $rol = Role::create([
            'name' => 'Permisos full',
        ]);
        
        $rol->syncPermissions(Permission::all());
        $rol->bases()->saveMany(Base::all());
        $rol->turnos()->saveMany(Turno::all());
    }
    
}
