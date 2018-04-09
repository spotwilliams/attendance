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

class SeederFromSqlFile extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Nro de lineas del file
        $bar = $this->command->getOutput()->createProgressBar(1269082);
        
        $file = new SplFileObject('NOMBRE DEL ARCHIVO.CON EXTENSION');
        while (!$file->eof()) {
            try {
                \Illuminate\Support\Facades\DB::insert($file->fgets());
            } catch (\Exception $e) {
            }
            $bar->advance();
        }
        
    }
    
    
}
