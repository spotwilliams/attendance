<?php

use Illuminate\Database\Seeder;

class ContratosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Cat\Models\Contrato::class, 20)->create();
    }
}
