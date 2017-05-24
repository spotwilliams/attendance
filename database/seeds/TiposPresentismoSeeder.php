<?php

use Illuminate\Database\Seeder;

class TiposPresentismoSeeder extends Seeder
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
                'id'              => 1,
                'id_padre'        => null,
                'codigo'          => 'PRESENTE',
                'descripcion'     => 'Presente',
                'color'           => '#4286f4',
                'dias_permitidos' => rand(1, 10),
            ],
            [
                'id'              => 2,
                'id_padre'        => null,
                'codigo'          => 'INJUSTIFICADO',
                'descripcion'     => 'Ausente injustificado',
                'color'           => '#ef2809',
                'dias_permitidos' => 0,
            ],
            [
                'id'              => 3,
                'id_padre'        => 1,
                'codigo'          => 'MEDICO_JUSTIFICADO',
                'descripcion'     => 'Medico justificado',
                'color'           => '#e1930f',
                'dias_permitidos' => rand(1, 10),
            ],
            [
                'id'              => 4,
                'id_padre'        => 2,
                'codigo'          => 'MEDICO_INJUSTIFICADO',
                'descripcion'     => 'Medico injustificado',
                'color'           => '#e0950f',
                'dias_permitidos' => rand(1, 10),
            ],
            [
                'id'              => 5,
                'id_padre'        => 1,
                'codigo'          => 'ESTUDIO_JUSTIFICADO',
                'descripcion'     => 'Estudio justificado',
                'color'           => '#0ae031',
                'dias_permitidos' => rand(1, 10),
            ],
            [
                'id'              => 6,
                'id_padre'        => 2,
                'codigo'          => 'ESTUDIO_INJUSTIFICADO',
                'descripcion'     => 'Estudio injustificado',
                'color'           => '#0ee131',
                'dias_permitidos' => rand(1, 10),
            ],
            [
                'id'              => 7,
                'id_padre'        => 1,
                'codigo'          => 'JUDIO_JUSTIFICADO',
                'descripcion'     => 'Festividad judia',
                'color'           => '#c7e026',
                'dias_permitidos' => rand(1, 10),
            ],
            
        ];
        
        foreach ($tipos as $nuevo) {
            \Cat\Models\TipoPresentismo::create($nuevo);
        }
    }
}
