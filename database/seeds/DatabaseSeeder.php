<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    const SIZE_AGENTE = 200;
    const SIZE_AREAS  = 5;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $this->call(UsersTableSeeder::class);
            
            $this->call(AreasSeeder::class);
            $this->call(BasesSeeder::class);
            $this->call(EstadosContratoSeeder::class);
            $this->call(TiposPresentismoSeeder::class);
            $this->call(TiposContratoSeeder::class);
            
            
            $this->call(AgentesSeeder::class);
            $this->call(DomicilioSeeder::class);
            $this->call(ContratosSeeder::class);
            $this->call(DiasDisponiblesSeeder::class);
            
//            $this->call(PeriodosSeeder::class);
        try {
        } catch (\Exception $error) {
            echo $error->getTraceAsString();
        }
    }
    
    
}
