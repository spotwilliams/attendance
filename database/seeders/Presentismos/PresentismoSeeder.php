<?php

namespace Database\Seeders\Presentismos;

use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Database\Seeders\Agentes\AgentesSeeder;
use Illuminate\Database\Seeder;

class PresentismoSeeder extends Seeder
{
    public function run()
    {
        $tipoIds = TipoPresentismo::pluck('id')->toArray();
        $periodos = Periodo::all();

        for ($i = 1; $i < AgentesSeeder::POPULATION_SIZE; $i++) {
            foreach ($periodos as $periodo) {
                $date = new \DateTime($periodo->fecha_comienzo);
                $end = new \DateTime($periodo->fecha_fin);

                while ($date <= $end) {
                    Presentismo::create([
                        'id_agente'           => $i,
                        'id_tipo_presentismo' => $tipoIds[array_rand($tipoIds)],
                        'fecha'               => $date->format('Y-m-d'),
                        'id_periodo'          => $periodo->id,
                    ]);
                    $date->modify('+1 day');
                }
            }
        }
    }
}
