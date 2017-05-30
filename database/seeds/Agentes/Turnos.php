<?php
namespace Cat\Database\Seeds\Agentes;

use Cat\Models\Turno;
use Illuminate\Database\Seeder;

class Turnos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $turnos = [
            ['codigo' => 'TI', 'descripcion' => ''],
            ['codigo' => 'TT', 'descripcion' => 'Turno tarde'],
            ['codigo' => 'MI', 'descripcion' => ''],
            ['codigo' => 'TM', 'descripcion' => ''],
            ['codigo' => 'ROT', 'descripcion' => 'Rotativo'],
            ['codigo' => 'FSD', 'descripcion' => ''],
            ['codigo' => 'FSN', 'descripcion' => ''],
            ['codigo' => 'TN', 'descripcion' => 'Turno noche'],
            ['codigo' => 'NI', 'descripcion' => ''],
            ['codigo' => 'FSI', 'descripcion' => ''],
            ['codigo' => 'EXIMIDO', 'descripcion' => 'Eximido'],
        ];
        
        foreach ($turnos as $t) {
            Turno::create($t);
        }
    }
}
