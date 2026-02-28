<?php

namespace Database\Seeders\Presentismos;

use Cat\Repositories\PeriodoRepository;
use Illuminate\Database\Seeder;

class PeriodosSeeder extends Seeder
{
    /**
     * Create 4 periods: 2 months back and 2 months ahead.
     * Each period runs from the 16th to the 15th of the next month.
     */
    public function run()
    {
        $cantDias = 30;
        $start = new \DateTime('-2 months');
        $start->setDate((int) $start->format('Y'), (int) $start->format('m'), 16);

        for ($i = 0; $i < 4; $i++) {
            $desde = clone $start;
            $hasta = clone $start;
            $hasta->modify('+1 month')->setDate((int) $hasta->format('Y'), (int) $hasta->format('m'), 15);

            $periodo = \Cat\Models\Periodo::create([
                'fecha_comienzo' => $desde->format('Y-m-d'),
                'fecha_fin'      => $hasta->format('Y-m-d'),
                'cant_dias'      => $cantDias,
            ]);

            PeriodoRepository::activarPeriodoEnBasesYTurnos($periodo);

            $start->modify('+1 month');
        }
    }
}
