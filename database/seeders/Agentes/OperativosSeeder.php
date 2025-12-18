<?php

namespace Database\Seeders\Agentes;

use Illuminate\Database\Seeder;

class OperativosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = new \Faker\Generator();
        
        $person = new \Faker\Provider\en_US\Person($faker);
        $faker->addProvider($person);
        
        $cuit = new \Faker\Provider\Uuid($faker);
        $faker->addProvider($cuit);
        
        for ($i = 1; $i < \DatabaseSeeder::SIZE_AGENTE; $i++) {
            
            $agente = [
                'id_agente'  => $i,
                'id_base'    => rand(1, \DatabaseSeeder::SIZE_AREAS),
                'id_area'    => rand(1, \DatabaseSeeder::SIZE_AREAS),
                'id_turno'   => rand(1, 11),
                'id_horario' => rand(1, 44),
                'id_funcion' => rand(1, 111),
            ];
            \Cat\Models\Operativo::create($agente);
        }
    }
}
