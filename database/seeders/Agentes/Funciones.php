<?php
namespace Database\Seeders\Agentes;

use Cat\Models\Funcion;
use Illuminate\Database\Seeder;

class Funciones extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 3; $i++) {
            Funcion::create([
                'id_padre' => null,
                'nombre'   => $faker->unique()->word(),
            ]);
        }
    }
}
