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
                'id_padre'        => 2,
                'codigo'          => 'MEDICO',
                'descripcion'     => 'Ausente con permiso medico',
                'color'           => '#e0930f',
                'dias_permitidos' => rand(1, 10),
            ],
            [
                'id'              => 4,
                'id_padre'        => 2,
                'codigo'          => 'ESTUDIO',
                'descripcion'     => 'Dias de estudio',
                'color'           => '#0ee031',
                'dias_permitidos' => rand(1, 10),
            ],
            [
                'id'              => 5,
                'id_padre'        => 2,
                'codigo'          => 'JUDIO',
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
