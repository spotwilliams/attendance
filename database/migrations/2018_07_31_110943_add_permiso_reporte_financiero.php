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
        
        try {
            $permiso = \Cat\Modules\Security\Models\Permission::where('name', '=', 'Reporte de haberes')
                ->firstOrFail();
            $permiso->fill($ps)->save();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $permiso = new \Cat\Modules\Security\Models\Permission($ps);
        }
        
        /** @var \Cat\Modules\Security\Models\Role $role */
        $role = \Cat\Modules\Security\Models\Role::find(1);//permisos full
        
        $role->syncPermissions(\Cat\Modules\Security\Models\Permission::all());
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
