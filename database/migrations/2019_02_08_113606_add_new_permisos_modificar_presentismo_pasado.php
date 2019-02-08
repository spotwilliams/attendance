<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewPermisosModificarPresentismoPasado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permiso = [
                'id' => null,
                'name' => 'Cargar presentismo pasado',
                'comentarios' => 'Permite registar el presentismo fuera de los limites permitidos normalmente',
        ];
        /** @var \Cat\Modules\Security\Models\Permission $permiso */
        $permiso = new \Cat\Modules\Security\Models\Permission($permiso);
        $permiso->save();


        $rol = [
                'id' => null,
                'name' => 'Cargador presentismo en dias pasados'
        ];
        /** @var \Cat\Modules\Security\Models\Role $rol */
        $rol = new \Cat\Modules\Security\Models\Role($rol);
        $rol->save();
        $rol->syncPermissions($permiso);

        $rol = \Cat\Modules\Security\Models\Role::where('name', '=', 'Permisos full')->first();
        $rol->syncPermissions(\Cat\Modules\Security\Models\Permission::all());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permiso = \Cat\Modules\Security\Models\Permission::where('name', 'Cargar presentismo pasado')->first();

        $rol = \Cat\Modules\Security\Models\Role::where('name', '=', 'Cargador presentismo en dias pasados')->first();
        $rol->revokePermissionTo($permiso);

        $permiso->delete();
        $rol->delete();


        // re sync
        $rol = \Cat\Modules\Security\Models\Role::where('name', '=', 'Permisos full')->first();

        $rol->syncPermissions(\Cat\Modules\Security\Models\Permission::all());
    }
}
