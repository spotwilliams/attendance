<?php
namespace Cat\Database\Seeds\Agentes;

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
        factory(\Cat\Models\Base::class, \DatabaseSeeder::SIZE_AREAS)->create();
    
    }
}
