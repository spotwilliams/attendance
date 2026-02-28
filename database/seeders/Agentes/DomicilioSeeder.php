<?php

namespace Database\Seeders\Agentes;

use Illuminate\Database\Seeder;

class DomicilioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = new \Faker\Generator();
        $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
        for ($i = 1; $i < \DatabaseSeeder::SIZE_AGENTE; $i++) {
            
            // Domicilio
            $domicilio = [
                'calle'        => $faker->streetName(),
                'numero'       => $faker->numberBetween(1, 100),
                'departamento' => $faker->numberBetween(1, 15),
                'piso'         => $faker->numberBetween(1, 4),
                'barrio'       => $faker->city(),
                'provincia'    => $faker->state(),
                'id_agente'    => $i,
                'constituido'  => rand(0, 1),
            ];
            \Cat\Models\Domicilio::create($domicilio);
        }
    }
}
