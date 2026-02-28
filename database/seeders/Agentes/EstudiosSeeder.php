<?php

namespace Database\Seeders\Agentes;

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
        $faker = \Faker\Factory::create();
        for ($i = 1; $i < AgentesSeeder::POPULATION_SIZE; $i++) {
            $estudio = [
                'id_agente'   => $i,
                'institucion' => substr($faker->company(), 0, 45),
                'carrera'     => substr($faker->words(2, true), 0, 45),
                'nivel'       => $faker->randomElement(['PRIMARIO', 'SECUNDARIO', 'TERCIARIO', 'UNIVERSITARIO']),
                'estado'      => $faker->randomElement(['COMPLETO', 'EN CURSO', 'INCOMPLETO']),
            ];
            \Cat\Models\Estudio::create($estudio);
        }
    }
}
