<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermisosNotificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ps = [
            'name'        => 'Notificacion de facturacion',
            'comentarios' => 'Permite enviar mails a los agentes con datos para facturar',
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
        $permiso = \Cat\Modules\Security\Models\Permission::where('name', '=', 'Notificacion de facturacion')
            ->first();
        
        /** @var \Cat\Modules\Security\Models\Role $role */
        $role = \Cat\Modules\Security\Models\Role::find(1);//permisos full
        
        $role->revokePermissionTo($permiso);
        
        $permiso->delete();
        
        
    }
}
