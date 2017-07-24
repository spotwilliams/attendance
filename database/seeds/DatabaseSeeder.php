<?php
//namespace Cat\Database\Seeds;

use Cat\Database\Presentismos\DiasDisponiblesSeeder;
use Cat\Database\Presentismos\TiposPresentismoSeeder;
use Cat\Database\Seeds\Agentes\AgentesSeeder;
use Cat\Database\Seeds\Agentes\AreasSeeder;
use Cat\Database\Seeds\Agentes\BasesSeeder;
use Cat\Database\Seeds\Agentes\ContratosSeeder;
use Cat\Database\Seeds\Agentes\DomicilioSeeder;
use Cat\Database\Seeds\Agentes\EstadosContratoSeeder;
use Cat\Database\Seeds\Agentes\Funciones;
use Cat\Database\Seeds\Agentes\Horarios;
use Cat\Database\Seeds\Agentes\TiposContratoSeeder;
use Cat\Database\Seeds\Agentes\Turnos;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    const SIZE_AGENTE = 2000;
    const SIZE_AREAS  = 10;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Cat\Database\Seeds\UsersTableSeeder::class);
        
        $this->call(AreasSeeder::class);
        $this->call(BasesSeeder::class);
        $this->call(EstadosContratoSeeder::class);
        $this->call(TiposPresentismoSeeder::class);
        $this->call(TiposContratoSeeder::class);
        $this->call(Funciones::class);
        $this->call(Turnos::class);
        $this->call(\Cat\Database\Seeds\Agentes\GerenciasSeeder::class);
        $this->call(\Cat\Database\Seeds\Agentes\CargosSeeder::class);
        $this->call(\Cat\Database\Presentismos\PeriodosSeeder::class);

        $this->call(\Cat\Database\Presentismos\DiasPermitidoSeeder::class);
        $this->call(AgentesSeeder::class);
        $this->call(\Cat\Database\Presentismos\PresentismoSeeder::class);
        
        try {
        } catch (\Exception $error) {
            echo $error->getTraceAsString();
        }
    }
    
    
}
