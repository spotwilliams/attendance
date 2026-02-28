<?php
namespace Database\Seeders\Agentes;

use Cat\Models\Base;
use Illuminate\Database\Seeder;

class BasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 18; $i++) {
            Base::create(['nombre' => $faker->unique()->city()]);
        }
        
    }
}
