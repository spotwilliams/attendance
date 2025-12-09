<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermisosDashboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ps = [
            'name'        => 'Datos estadisticos inicio',
            'comentarios' => 'Permite ver los datos estadisticos generados al inicio',
        ];
    
        $permiso = \Cat\Modules\Security\Models\Permission::firstOrCreate(
            ['name' => $ps['name']],
            $ps
        );

        /** @var \Cat\Modules\Security\Models\Role $role */
        $role = \Cat\Modules\Security\Models\Role::find(1);//permisos full

        // Only sync if role exists (requires seed data)
        if ($role !== null) {
            $role->syncPermissions([$permiso]);
        }
    }
    
    /**
     * @throws Exception
     */
    public function down()
    {
    
        /** @var \Cat\Modules\Security\Models\Permission $permiso */
        $permiso = \Cat\Modules\Security\Models\Permission::where('name', '=', 'Datos estadisticos inicio')
            ->first();
    
        /** @var \Cat\Modules\Security\Models\Role $role */
        $role = \Cat\Modules\Security\Models\Role::find(1);//permisos full
    
        $role->revokePermissionTo($permiso);
    
        $permiso->delete();
        
       
    }
}
