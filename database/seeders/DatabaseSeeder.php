<?php
namespace Database\Seeders;

use Database\Seeders\Presentismos\DiasPermitidoSeeder;
use Database\Seeders\Presentismos\PresentismoSeeder;
use Database\Seeders\Agentes\EstudiosSeeder;
use Database\Seeders\Agentes\GerenciasSeeder;
use Database\Seeders\Agentes\CargosSeeder;
use Database\Seeders\Presentismos\PeriodosSeeder;
use Database\Seeders\Presentismos\TiposPresentismoSeeder;
use Database\Seeders\Agentes\AgentesSeeder;
use Database\Seeders\Agentes\AreasSeeder;
use Database\Seeders\Agentes\Horarios;
use Database\Seeders\Agentes\BasesSeeder;
use Database\Seeders\Agentes\EstadosContratoSeeder;
use Database\Seeders\Agentes\Funciones;
use Database\Seeders\Agentes\TiposContratoSeeder;
use Database\Seeders\Agentes\Turnos;
use Illuminate\Database\Seeder;
use Database\Seeders\Security\UsersTableSeeder;
use Database\Seeders\Security\PermissionSeeder;
use Database\Seeders\Security\RolSeeder;

class DatabaseSeeder extends Seeder
{
    const SIZE_AGENTE = 500;
    const SIZE_AREAS  = 10;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->parametros();
        $this->seguridad();
        //$this->agentes();
    }
    
    private function agentes()
    {
        $this->call(AgentesSeeder::class);
        $this->call(PresentismoSeeder::class);
        $this->call(EstudiosSeeder::class);
    }
    
    private function seguridad()
    {
        $this->call(PermissionSeeder::class);
        $this->call(RolSeeder::class);
        $this->call(UsersTableSeeder::class);
    
    }
    
    private function parametros()
    {
        $this->call(AreasSeeder::class);
        $this->call(BasesSeeder::class);
        $this->call(EstadosContratoSeeder::class);
        $this->call(TiposPresentismoSeeder::class);
        $this->call(TiposContratoSeeder::class);
        $this->call(Funciones::class);
        $this->call(Turnos::class);
        $this->call(GerenciasSeeder::class);
        $this->call(CargosSeeder::class);
        $this->call(PeriodosSeeder::class);
        $this->call(DiasPermitidoSeeder::class);
        $this->call(Horarios::class);
    }
    
    
}
