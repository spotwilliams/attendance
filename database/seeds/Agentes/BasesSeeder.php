<?php
namespace Cat\Database\Seeds\Agentes;

use Cat\Models\Base;
use Illuminate\Database\Seeder;

class BasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bases = [
            'Aeroparque',
            'Araoz de la Madrid',
            'BRD Sarmiento',
            'BRD Garay',
            'Chacabuco',
            'Cochabamba',
            'Cucc',
            'Dakota',
            'Las Heras',
            'Obelisco',
            'P. Madero',
            'Parque Vial',
            'Piedras',
            'Río Cuarto',
            'T. Obelisco',
        ];
        
        foreach ($bases as $b) {
            Base::create(['nombre' => $b]);
        }
        
    }
}
