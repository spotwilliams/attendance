<?php
namespace Database\Seeders\Agentes;

use Cat\Models\Area;
use Cat\Models\Cargo;
use Illuminate\Database\Seeder;

class CargosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $cargos = [
            
            'Gerente',
            'Subgerente',
            'Supervisor',
            'Coordinador',
            'Coordinador Gral.',
            'Jefe de Departamento',
            'Jefe de Base',
            'Jefe de gr&uacute;s Brd',
            'Coordinador',
        ];
        
        foreach ($cargos as $c) {
            Cargo::create(
                [
                    'nombre' => $c,
                ]
            );
        }
        
    }
}
