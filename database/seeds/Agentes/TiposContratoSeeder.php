<?php

namespace Cat\Database\Seeds\Agentes;

use Illuminate\Database\Seeder;

class TiposContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            [
                'id'          => 1,
                'descripcion' => 'Regimen Gerencial',
                'codigo'      => 'SITUACION_REVISTA',
            ],
            [
                'id'          => 2,
                'descripcion' => 'Planta Transitoria Anual',
                'codigo'      => 'SITUACION_REVISTA',
            ],
            [
                'id'          => 3,
                'descripcion' => 'Planta de Gabinete',
                'codigo'      => 'SITUACION_REVISTA',
            ],
            [
                'id'          => 4,
                'descripcion' => 'Planta Permanente',
                'codigo'      => 'SITUACION_REVISTA',
            ],
            [
                'id'          => 5,
                'descripcion' => 'Planta Transitoria',
                'codigo'      => 'SITUACION_REVISTA',
            ],
            [
                'id'          => 6,
                'descripcion' => 'Planta Transitoria 959/07',
                'codigo'      => 'SITUACION_REVISTA',
            ],
            [
                'id'          => 7,
                'descripcion' => 'Obra',
                'codigo'      => 'LOCACION',
            ],
            [
                'id'          => 8,
                'descripcion' => 'Servicios',
                'codigo'      => 'LOCACION',
            ],
        ];
        
        foreach ($tipos as $nuevo) {
            \Cat\Models\TipoContrato::create($nuevo);
        }
    }
}
