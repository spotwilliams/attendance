<?php

use Cat\Database\Presentismos\DiasPermitidoSeeder;
use Cat\Database\Presentismos\PresentismoSeeder;
use Cat\Database\Seeds\Agentes\EstudiosSeeder;
use Cat\Database\Seeds\Agentes\GerenciasSeeder;
use Cat\Database\Seeds\Agentes\CargosSeeder;
use Cat\Database\Presentismos\PeriodosSeeder;
use Cat\Database\Presentismos\TiposPresentismoSeeder;
use Cat\Database\Seeds\Agentes\AgentesSeeder;
use Cat\Database\Seeds\Agentes\AreasSeeder;
use Cat\Database\Seeds\Agentes\BasesSeeder;
use Cat\Database\Seeds\Agentes\EstadosContratoSeeder;
use Cat\Database\Seeds\Agentes\Funciones;
use Cat\Database\Seeds\Agentes\TiposContratoSeeder;
use Cat\Database\Seeds\Agentes\Turnos;
use Illuminate\Database\Seeder;
use Cat\Database\Security\UsersTableSeeder;
use Cat\Database\Security\PermissionSeeder;
use Cat\Database\Security\RolSeeder;

class DatabaseSeeder extends Seeder
{
    const SIZE_AGENTE = 2500;
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
        $this->agentes();
        
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
    }
    
    
}
