<?php

use Illuminate\Database\Seeder;

class PermisoReporteHaberesSeeder extends Seeder
{
    
    public function run()
    {
        $permission = \Cat\Modules\Security\Models\Permission::create([
            'name'        => 'Reporte de haberes',
            'comentarios' => 'Permite obtener el reporte de haberes',
        ]);
        
        \Cat\Modules\Security\Models\Role::findByName('Permisos full')
            ->syncPermissions(\Cat\Modules\Security\Models\Permission::all());
    }
}
