<?php
namespace Cat\Database\Seeds\Agentes;

use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Cat\Models\Area::class, \DatabaseSeeder::SIZE_AREAS)->create();
    
    }
}
