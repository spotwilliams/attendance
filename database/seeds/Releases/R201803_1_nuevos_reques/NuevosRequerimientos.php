<?php

namespace Cat\Database\Seeds\Releases\R201803_1_nuevos_reques;

use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Cat\Modules\Security\Models\Permission;
use Illuminate\Database\Seeder;

class NuevosRequerimientos extends Seeder
{
    
    public function run()
    {
        $ps = [
            // Eliminacion de configuraciones
//            [
//                'id'          => 21,
//                'name'        => 'Eliminar area',
//                'comentarios' => '',
//            ],
//            [
//                'id'          => 22,
//                'name'        => 'Eliminar base',
//                'comentarios' => '',
//            ],
//            [
//                'id'          => 23,
//                'name'        => 'Eliminar turno',
//                'comentarios' => '',
//            ],
            
            [
                'id'          => 24,
                'name'        => 'Vista previa liquidacion',
                'comentarios' => '',
            ],
            [
                'id'          => 25,
                'name'        => 'Modificar contratos',
                'comentarios' => '',
            ],
        ];
        
        
        foreach ($ps as $p) {
            try {
                Permission::create($p);
            } catch (\Exception $e) {
            }
        }
    }
}
