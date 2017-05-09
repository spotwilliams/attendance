<?php

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
        factory(\Cat\Models\Base::class, 20)->create();
    
    }
}
