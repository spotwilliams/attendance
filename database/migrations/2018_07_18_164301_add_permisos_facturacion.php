<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermisosFacturacion extends Migration
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
    
        $permiso = new \Cat\Modules\Security\Models\Permission($ps);
    
        $permiso->save();
    
    
        /** @var \Cat\Modules\Security\Models\Role $role */
        $role = \Cat\Modules\Security\Models\Role::find(1);//permisos full
        
        $role->syncPermissions([$permiso]);
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
}
