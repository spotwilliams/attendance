<?php

namespace Cat\Database\Presentismos;

use Cat\Database\Seeds\DatabaseSeeder;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Repositories\PeriodoRepository;
use Faker\Provider\DateTime;
use Illuminate\Database\Seeder;

class PresentismoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposPresentismos = array_keys(TipoPresentismo::all(['id'])->keyBy('id')->toArray());
        
        for ($i = 1; $i < \DatabaseSeeder::SIZE_AGENTE; $i++) {
            
            $today = new \DateTime();
            $start = new \DateTime('2017-01-01');
            while ($start <= $today) {
                Presentismo::create([
                    'id_agente'           => $i,
                    'id_tipo_presentismo' => $tiposPresentismos[rand(1, count($tiposPresentismos) - 1)],
                    'fecha'               => $start->format('Y-m-d'),
                    'id_periodo'          => 1,
                ]);
                
                $start->modify('+1day');
            }
        }
        
    }
}
