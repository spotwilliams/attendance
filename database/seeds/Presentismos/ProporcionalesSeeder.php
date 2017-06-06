<?php
namespace Cat\Database\Presentismos;

use Cat\Models\Proporcional;
use Illuminate\Database\Seeder;

class ProporcionalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pro = [
            [
                'mes_ingreso' => 'JULIO'
            ],
            [
                'mes_ingreso' => 'AGOSTO'
            ],
            [
                'mes_ingreso' => 'SEPTIEMBRE'
            ],
            [
                'mes_ingreso' => 'OCTUBRE'
            ],
            [
                'mes_ingreso' => 'NOVIEMBRE'
            ],
            [
                'mes_ingreso' => 'DICIEMBRE'
            ],
        ];
        
        foreach ($pro as $p) {
            Proporcional::create($p);
        }
    }
    
}
