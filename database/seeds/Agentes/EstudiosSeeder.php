<?php

namespace Cat\Database\Seeds\Agentes;

use Illuminate\Database\Seeder;

class EstudiosSeeder extends Seeder
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
                'id_agente'   => $i,
                'institucion' => 'lalsksd',
                'carrera'     => 'lalsksd',
                'nivel'       => 'SECUNDARIO',
                'estado'      => 'COMPLETO',
            ];
            \Cat\Models\Estudio::create($domicilio);
        }
    }
}
