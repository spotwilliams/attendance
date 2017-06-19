<?php

namespace Cat\Database\Presentismos;

use Cat\Database\Seeds\DatabaseSeeder;
use Cat\Repositories\PeriodoRepository;
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
        
        $cantDías = 30;
//        $cantPeriodos = 50;
        
        $now   = new \DateTime();
        $desde = new \DateTime($now->format('Y') .
            '-' .
            $now->format('m') .
            '-16'
        );
        $now->modify('+1month');
        $hasta = new \DateTime(
            $now->format('Y') .
            '-' .
            $now->format('m') .
            '-15');
        
        $periodo = [
            'fecha_comienzo' => $desde->format('Y-m-d'),
            'fecha_fin'      => $hasta->format('Y-m-d'),
            'cant_dias'      => $cantDías,
        ];
        
        $periodo = \Cat\Models\Periodo::create($periodo);
        
        PeriodoRepository::activarPeriodoEnBasesYTurnos($periodo);

    }
}
