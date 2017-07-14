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
            'Playa Aeroparque',
            'Araoz de la Madrid',
            'BRD Sarmiento',
            'BRD Tacuarí',
            'Chacabuco',
            'Cochabamba',
            'Cucc',
            'Dakota',
            'Las Heras',
            'Obelisco',
            'Puerto Madero',
            'Parque Vial',
            'Piedras',
            'Río Cuarto',
            'Terminal Obelisco',
            'Playa California',
            'Balcarce',
            'Playa de acarreo',
        ];
        
        foreach ($bases as $b) {
            Base::create(['nombre' => $b]);
        }
        
    }
}
