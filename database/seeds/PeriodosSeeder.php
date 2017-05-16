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
        $cantPeriodos = round (date('z') / $cantDías);
        
        $date  = new DateTime('2017-01-01');
        $date2 = new DateTime('2017-01-15');
        for ($i = 1; $i <= $cantPeriodos ; $i++) {
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
            \Cat\Models\JornadaLaborable::create([
                'fecha'      => $dateRan->format('Y-m-d'),
                'id_periodo' => $idPeriodo,
            ]);
        }
    }
}
