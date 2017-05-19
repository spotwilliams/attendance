<?php

use Illuminate\Database\Seeder;

class PeriodosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $cantDías     = 15;
//        $cantPeriodos = round(date('z') / $cantDías);
        $cantPeriodos = 50;
        
        $date  = new DateTime('2017-01-01');
        $date2 = new DateTime('2017-01-15');
        for ($i = 1; $i <= $cantPeriodos; $i++) {
            //
            //
            // creacion periodo
            //
            //
            //
            $periodo = [
                'id'             => $i,
                'fecha_comienzo' => $date->format('Y-m-d'),
                'fecha_fin'      => $date2->format('Y-m-d'),
                'cant_dias'      => $cantDías,
            ];
            $date->modify("+$cantDías day");
            $date2->modify("+$cantDías day");
            
            \Cat\Models\Periodo::create($periodo);
            
            // creacion jornadas para periodo
            $this->crearJornadas($date, $date2, $i);
            
            // crear estados para periodo
            $this->crearEstados($i, ($i == $cantPeriodos));
        }
    }
    
    private function crearEstados($idPeriodo, $abierto = false)
    {
        for ($i = 1; $i <= 5; $i++) {
            \Cat\EstadoPeriodo::create(
                [
                    'id_base'    => $i,
                    'id_periodo' => $idPeriodo,
                    'abierto'    => $abierto,
                ]
            );
        }
        
    }
    
    private function crearJornadas($beginPeriodo, $endPeriodo, $idPeriodo)
    {
        $interval  = new DateInterval('P1D');
        $daterange = new DatePeriod($beginPeriodo, $interval, $endPeriodo);
        
        foreach ($daterange as $dateRan) {
            $jornada = \Cat\Models\JornadaLaborable::create([
                'fecha'      => $dateRan->format('Y-m-d'),
                'id_periodo' => $idPeriodo,
            ]);
            $this->crearPresentismo($jornada);
        }
    }
    
    private function crearPresentismo(\Cat\Models\JornadaLaborable $jornada)
    {
        for ($i = 1; $i < DatabaseSeeder::SIZE_AGENTE; $i++) {
            \Cat\Models\Presentismo::create([
                'id_tipo_presentismo' => rand(1, 5),
                'id_agente'           => $i,
                'id_jornada'          => $jornada->id,
                'comentario'          => \Faker\Provider\Lorem::paragraphs(3, true),
            ]);
        }
    }
}
