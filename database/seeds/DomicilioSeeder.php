<?php

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
        factory(\Cat\Models\Domicilio::class, 20)->create();
    
    }
}
