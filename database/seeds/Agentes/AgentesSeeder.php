<?php

namespace Cat\Database\Seeds\Agentes;

use Illuminate\Database\Seeder;

class AgentesSeeder extends Seeder
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
        
        for ($i = 1; $i < DatabaseSeeder::SIZE_AGENTE; $i++) {
            
            $agente = [
                'nombre'           => $faker->name(),
                'apellido'         => $faker->lastName(),
                'dni'              => rand(3000000, 50000000),
                'fecha_nacimiento' => date('Y-m-d'),
                'cuit'             => $faker->uuid(),
                'id_base'          => rand(1, 5),
                'id_area'          => rand(1, 5),
            ];
            \Cat\Models\Agente::create($agente);
        }
    }
}
