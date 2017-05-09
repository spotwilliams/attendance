<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
         $this->call(UsersTableSeeder::class);
         $this->call(EstadosContratoSeeder::class);
         $this->call(TiposContratoSeeder::class);
         $this->call(TiposPresentismoSeeder::class);
         $this->call(AgentesSeeder::class);
         $this->call(DiasDisponiblesSeeder::class);
    }
}
