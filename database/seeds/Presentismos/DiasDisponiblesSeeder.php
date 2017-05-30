<?php
namespace Cat\Database\Presentismos;

use Cat\Database\Seeds\DatabaseSeeder;
use Illuminate\Database\Seeder;

class DiasDisponiblesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < DatabaseSeeder::SIZE_AGENTE; $i++) {
            for ($j = 3; $j <= 5; $j++) {
                
                $diasDisponible
                    = [
                    'id_agente'           => $i,
                    'id_tipo_presentismo' => $j,
                    'cant_dias'           => rand(1, 10),
                ];
                \Cat\Models\DiaDisponible::create($diasDisponible);
            }
        }
    }
}
