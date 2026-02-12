<?php

namespace Database\Seeders\Security;

use Cat\Modules\Security\Models\Permission;
use Cat\Modules\Security\Models\Role;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run()
    {
        $rol = Role::create([
            'name' => 'Permisos full',
        ]);
        
        $rol->syncPermissions(Permission::all());
    }
    
}
