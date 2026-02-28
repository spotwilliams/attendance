<?php
namespace Database\Seeders\Agentes;

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
        $faker = \Faker\Factory::create();

        // Top-level gerencias
        for ($i = 1; $i <= 7; $i++) {
            Gerencia::create([
                'nombre'   => $faker->unique()->company(),
                'id_padre' => null,
            ]);
        }

        // Sub-gerencias under gerencia 3
        for ($i = 0; $i < 3; $i++) {
            Gerencia::create([
                'nombre'   => $faker->unique()->company(),
                'id_padre' => 3,
            ]);
        }
    }
}
