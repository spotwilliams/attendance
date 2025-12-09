<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermisoReporteFinanciero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ps = [
            'name'        => 'Reporte de facturacion',
            'comentarios' => 'Permite ver el reporte de facturacion',
        ];

        $permiso = \Cat\Modules\Security\Models\Permission::where('name', '=', 'Reporte de haberes')->first();
        if ($permiso !== null) {
            $permiso->fill($ps)->save();
        } else {
            $permiso = \Cat\Modules\Security\Models\Permission::firstOrCreate(
                ['name' => $ps['name']],
                $ps
            );
        }

        /** @var \Cat\Modules\Security\Models\Role $role */
        $role = \Cat\Modules\Security\Models\Role::find(1);//permisos full

        // Only sync if role exists (requires seed data)
        if ($role !== null) {
            $role->syncPermissions(\Cat\Modules\Security\Models\Permission::all());
        }
    }
    
    /**
     * @throws Exception
     */
    public function down()
    {
        /** @var \Cat\Modules\Security\Models\Permission $permiso */
        $permiso = \Cat\Modules\Security\Models\Permission::where('name', '=', 'Reporte de facturacion')
            ->first();
        
        /** @var \Cat\Modules\Security\Models\Role $role */
        $role = \Cat\Modules\Security\Models\Role::find(1);//permisos full
        
        $role->revokePermissionTo($permiso);
        
        $permiso->delete();
    }
}
