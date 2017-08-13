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
//            ['name' => 'Buscar personal', 'comentarios' => ''],
            ['name' => 'Alta individual personal', 'comentarios' => 'Permite registar de manera individual los datos de un personal'],
            ['name' => 'Alta masiva personal', 'comentarios' => 'Permite registar de manera individual los datos de un personal'],
            ['name' => 'Modificar personal individual', 'comentarios' => 'Permite registar de manera individual los datos de un personal'],
            
            // Presentismos
            ['name' => 'Modificar presentismo', 'comentarios' => 'Permite modificar un presentismo previamente asignado',],
            ['name' => 'Cargar presentismo individual', 'comentarios' => '',],
            ['name' => 'Cargar presentismo masivo', 'comentarios' => '',],
            ['name' => 'Justificar presentismo', 'comentarios' => '',],
            
            // Haberes
            ['name' => 'Calcular haberes', 'comentarios' => '',],
//
            // Reportes
            ['name' => 'Ver y Exportar Reportes', 'comentarios' => '',],
            
            // Sistema
            ['name' => 'Configurar sistema', 'comentarios' => '',],
            ['name' => 'Configurar permisos', 'comentarios' => '',],
        
        ];
        
        return $ps;
    }
}




