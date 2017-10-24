<?php

use Illuminate\Database\Seeder;

class PermisoReporteHaberesSeeder extends Seeder
{
    
    public function run()
    {
        \Cat\Modules\Security\Models\Permission::create([
            'name'        => 'Reporte de haberes',
            'comentarios' => 'Permite obtener el reporte de haberes',
        ]);
        
        \Cat\Modules\Security\Models\Permission::create([
            'name'        => 'Justificar licencia M - LOCACION',
            'comentarios' => 'Permite justificar las licencias de medico para locacion',
        ]);
        
        \Cat\Modules\Security\Models\Role::findByName('Permisos full')
            ->syncPermissions(\Cat\Modules\Security\Models\Permission::all());
    }
}
