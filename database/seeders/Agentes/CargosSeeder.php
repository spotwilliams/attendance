<?php
namespace Database\Seeders\Agentes;

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
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 9; $i++) {
            Cargo::create([
                'nombre' => substr($faker->unique()->jobTitle(), 0, 80),
            ]);
        }
    }
}
