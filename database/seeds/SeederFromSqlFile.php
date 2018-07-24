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
        $this->file(__DIR__ . '/backups/cat_public_agentes.sql', 2862);
        $this->file(__DIR__ . '/backups/cat_public_areas.sql', 34);
        $this->file(__DIR__ . '/backups/cat_public_bases.sql', 21);
        $this->file(__DIR__ . '/backups/cat_public_cargos.sql', 9);
        $this->file(__DIR__ . '/backups/cat_public_domicilios.sql', 7248);
        $this->file(__DIR__ . '/backups/cat_public_estudios.sql', 3999);
        $this->file(__DIR__ . '/backups/cat_public_funciones.sql', 3);
        $this->file(__DIR__ . '/backups/cat_public_gerencias.sql', 10);
        $this->file(__DIR__ . '/backups/cat_public_tipo_contratos.sql', 8);
        $this->file(__DIR__ . '/backups/cat_public_tipos_presentismos.sql', 68);
        $this->file(__DIR__ . '/backups/cat_public_estado_contratos.sql', 7);
        $this->file(__DIR__ . '/backups/cat_public_periodos.sql', 40);
        $this->file(__DIR__ . '/backups/cat_public_estado_periodos.sql', 7227);
        $this->file(__DIR__ . '/backups/cat_public_dias_permitidos.sql', 222);
        $this->file(__DIR__ . '/backups/cat_public_horarios.sql', 2827);
        $this->file(__DIR__ . '/backups/cat_public_turnos.sql', 11);
        $this->file(__DIR__ . '/backups/cat_public_roles.sql', 19);
        $this->file(__DIR__ . '/backups/cat_public_users.sql', 51);
        $this->file(__DIR__ . '/backups/cat_public_permissions.sql', 22);


        $this->file(__DIR__ . '/backups/cat_public_base_roles.sql', 211);
        $this->file(__DIR__ . '/backups/cat_public_turno_roles.sql', 130);
        $this->file(__DIR__ . '/backups/cat_public_role_users.sql', 99);
        $this->file(__DIR__ . '/backups/cat_public_permission_users.sql', 1);
        $this->file(__DIR__ . '/backups/cat_public_permission_roles.sql', 124);
        
        $this->file(__DIR__ . '/backups/cat_public_contratos.sql', 2820);
        $this->file(__DIR__ . '/backups/cat_public_contratos_historicos.sql', 2854);
        $this->file(__DIR__ . '/backups/cat_public_operativos.sql', 2728);
        $this->file(__DIR__ . '/backups/cat_public_operativos_historicos.sql', 1);
        $this->file(__DIR__ . '/backups/cat_public_turnos_historicos.sql', 3156);

        $this->file(__DIR__ . '/backups/cat_public_presentismos.sql', 1693132);
        $this->file(__DIR__ . '/backups/cat_public_comentarios.sql', 67978);
        $this->file(__DIR__ . '/backups/cat_public_haberes.sql', 1198);
        $this->file(__DIR__ . '/backups/cat_public_facturas_fisicas.sql', 1);
        $this->file(__DIR__ . '/backups/cat_public_notificaciones.sql', 1);
        
        $this->file(__DIR__ . '/backups/cat_public_params.sql', 3);
        $this->file(__DIR__ . '/backups/cat_public_migrations.sql', 58);
        
        
        
        
    }
    
    public function file($fileName, $lines)
    {
        // Nro de lineas del file
        $bar  = $this->command->getOutput()->createProgressBar($lines);
        $file = new SplFileObject($fileName);
        
        while (!$file->eof()) {
            try {
                \Illuminate\Support\Facades\DB::insert($file->fgets());
            } catch (\Illuminate\Database\QueryException $e) {
            } catch (\Exception $e) {
                $this->command->info($e->getMessage());
            }
            $bar->advance();
        }
    }
    
    
}
