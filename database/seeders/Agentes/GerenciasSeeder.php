<?php
namespace Database\Seeders\Agentes;

use Cat\Models\Area;
use Cat\Models\Cargo;
use Cat\Models\Gerencia;
use Illuminate\Database\Seeder;

class GerenciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $gerencias = [
            [
                'id'       => 10,
                'nombre'   => 'Gerencia Operativa Cuerpo de Fiscalización en la Vía Pública',
                'id_padre' => null,
            ],
            [
                'id'       => 1,
                'nombre'   => 'Dirección General',
                'id_padre' => null,
            ],
            [
                'id'       => 2,
                'nombre'   => 'Gerencia Operativa de Educación Vial',
                'id_padre' => null,
            ],
            [
                'id'       => 3,
                'nombre'   => 'Gerencia Operativa de Gestión de Operaciones',
                'id_padre' => null,
            ],
            [
                'id'       => 4,
                'nombre'   => 'Subgerencia Operativa Base Chacabuco',
                'id_padre' => 3,
            ],
            [
                'id'       => 5,
                'nombre'   => 'Subgerencia Operativa Base Piedras',
                'id_padre' => 3,
            ],
            [
                'id'       => 6,
                'nombre'   => 'Subgerencia Operativa Base Heras',
                'id_padre' => 3,
            ],
            [
                'id'       => 7,
                'nombre'   => 'Gerencia Operativa de Recursos Materiales',
                'id_padre' => null,
            ],
            [
                'id'       => 8,
                'nombre'   => 'Subgerencia Operativa de Recursos Materiales',
                'id_padre' => 7,
            ],
            [
                'id'       => 9,
                'nombre'   => 'Subgerencia Operativa de Personal',
                'id_padre' => null,
            ],
        ];
        
        foreach ($gerencias as $g) {
            Gerencia::create($g);
        }
        
    }
}
