<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewPermisosModificarFechaContratoPasado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permisoData = [
                'id' => null,
                'name' => 'Cargar contratos pasados',
                'comentarios' => 'Permite registar contratos con fecha de inicio anterior al limite permitido',
        ];
        /** @var \Cat\Modules\Security\Models\Permission $permiso */
        $permiso = \Cat\Modules\Security\Models\Permission::firstOrCreate(
            ['name' => $permisoData['name']],
            $permisoData
        );

        $rolData = [
                'id' => null,
                'name' => 'Cargador contratos con fecha inicio pasado'
        ];
        /** @var \Cat\Modules\Security\Models\Role $rol */
        $rol = \Cat\Modules\Security\Models\Role::firstOrCreate(
            ['name' => $rolData['name']],
            $rolData
        );
        // Only sync if pivot table exists
        if (\Schema::hasTable('role_has_permissions')) {
            $rol->syncPermissions($permiso);
        }

        $rolFull = \Cat\Modules\Security\Models\Role::where('name', '=', 'Permisos full')->first();
        // Only sync if role exists and pivot table exists
        if ($rolFull !== null && \Schema::hasTable('role_has_permissions')) {
            $rolFull->syncPermissions(\Cat\Modules\Security\Models\Permission::all());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permiso = \Cat\Modules\Security\Models\Permission::where('name', 'Cargar contratos pasados')->first();

        $rol = \Cat\Modules\Security\Models\Role::where('name', '=', 'Cargador contratos con fecha inicio pasado')->first();
        $rol->revokePermissionTo($permiso);

        $permiso->delete();
        $rol->delete();


        // re sync
        $rol = \Cat\Modules\Security\Models\Role::where('name', '=', 'Permisos full')->first();

        $rol->syncPermissions(\Cat\Modules\Security\Models\Permission::all());
    }
}
