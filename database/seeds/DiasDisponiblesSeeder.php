<?php

use Illuminate\Database\Seeder;

class DiasDisponiblesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Cat\Models\DiaDisponible::class, 20)->create();
    }
}
