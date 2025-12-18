<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Cat\Modules\Security\Models\Permission::where('name', '=', 'Calcular haberes')
            ->delete();
        
        $ps = [
            'name'        => 'Registro facturacion',
            'comentarios' => 'Permite registrar para un periodo a quienes se les facturo',
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
        $permiso = \Cat\Modules\Security\Models\Permission::where('name', '=', 'Registro facturacion')
            ->first();
        
        /** @var \Cat\Modules\Security\Models\Role $role */
        $role = \Cat\Modules\Security\Models\Role::find(1);//permisos full
        
        $role->revokePermissionTo($permiso);
        
        $permiso->delete();
        
        
    }
};
