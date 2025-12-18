<?php

namespace Database\Seeders\Presentismos;

use Cat\Database\Seeds\DatabaseSeeder;
use Cat\Repositories\PeriodoRepository;
use Faker\Provider\DateTime;
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
        
        $now = new \DateTime('2016-12-16');
        if ($now->format('d') < 15) {
            $now = new \DateTime($now->format('Y') .
                '-' .
                ($now->format('m') - 1) .
                '-16');
        }
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
            'fecha_comienzo' => $desde,//->format('Y-m-d'),
            'fecha_fin'      => $hasta,//->format('Y-m-d'),
            'cant_dias'      => $cantDías,
        ];
        
        $periodo = \Cat\Models\Periodo::create($periodo);
        
        PeriodoRepository::activarPeriodoEnBasesYTurnos($periodo);
        
    }
}
