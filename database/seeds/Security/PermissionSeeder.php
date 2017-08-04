<?php

namespace Cat\Database\Security;

use Cat\Modules\Security\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = $this->getPermission();
        
        foreach ($permissions as $p) {
            Permission::create($p);
        }
    }
    
    private function getPermission()
    {
        $ps = [
            ['name' => 'Buscar personal', 'comentarios' => ''],
            ['name' => 'Guardar datos laborales', 'comentarios' => ''],
            ['name' => 'Modificar datos laborales', 'comentarios' => ''],
            ['name' => 'Eliminar datos laborales', 'comentarios' => ''],
            ['name' => 'Guardar datos operativos', 'comentarios' => ''],
            ['name' => 'Modificar datos operativos', 'comentarios' => ''],
            ['name' => 'Eliminar datos operativos', 'comentarios' => ''],
            ['name' => 'Guardar datos personales', 'comentarios' => ''],
            ['name' => 'Modificar datos personales', 'comentarios' => ''],
            ['name' => 'Eliminar datos personales', 'comentarios' => ''],
            
            ['name' => 'Listar personal por base', 'comentarios' => ''],
            ['name' => 'Ver ficha de personal', 'comentarios' => ''],
            
            ['name' => 'Cargar personal masivo', 'comentarios' => '',],
            ['name' => 'Cargar presentismo masivo', 'comentarios' => '',],
        
        
        ];
        
        return $ps;
    }
}




